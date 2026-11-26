<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Controller/HomeController.php';
require_once __DIR__ . '/../src/Controller/CatalogController.php';

$root = dirname(__DIR__);

try {
    $router = new Router($root . '/dataset/routes.csv');
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $route = $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $path);

    if ($route === null) {
        http_response_code(404);
        $title = 'Страница не найдена';
        ob_start();
        require $root . '/views/not-found.php';
        $content = ob_get_clean();
    } else {
        [$controllerName, $action] = $route;

        if ($controllerName === 'HomeController') {
            $pageData = json_decode(
                (string) file_get_contents($root . '/dataset/pages.json'),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            $controller = new HomeController($pageData);
            $data = $controller->$action();
            $viewFile = $root . '/views/home/index.php';
            $title = (string) ($data['shop_name'] ?? 'Главная');
        } elseif ($controllerName === 'CatalogController') {
            $controller = new CatalogController();
            $data = $controller->$action();
            $viewFile = $root . '/views/catalog/index.php';
            $title = (string) ($data['title'] ?? 'Каталог');
        } else {
            throw new RuntimeException('Для маршрута указан неизвестный контроллер.');
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
    }
} catch (Throwable $exception) {
    http_response_code(500);
    $title = 'Ошибка приложения';
    $content = '<section class="hero"><h1>Не удалось открыть страницу</h1><p>Проверьте файлы проекта и dataset.</p></section>';
}

require $root . '/views/layout.php';
