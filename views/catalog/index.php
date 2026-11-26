<section class="page-heading">
    <div class="eyebrow">ВЫБЕРИТЕ ИГРУ</div>
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
    <p>Подборка настольных игр для разных компаний и настроений.</p>
</section>
<section class="product-grid">
    <?php foreach ($products as $product): ?>
        <article class="product-card">
            <div class="product-placeholder" aria-hidden="true">♟</div>
            <div class="eyebrow"><?= htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') ?></div>
            <h2><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h2>
            <strong><?= number_format((int) $product['price'], 0, ',', ' ') ?> ₽</strong>
        </article>
    <?php endforeach; ?>
</section>
