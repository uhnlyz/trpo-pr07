<?php
declare(strict_types=1);

final class CatalogController
{
    public function index(): array
    {
        return [
            'title' => 'Каталог настольных игр',
            'products' => [
                ['name' => 'Каркассон', 'category' => 'Стратегии', 'price' => 2490],
                ['name' => 'Диксит', 'category' => 'Для компании', 'price' => 3190],
                ['name' => 'Азул', 'category' => 'Абстрактные игры', 'price' => 2890],
            ],
        ];
    }
}
