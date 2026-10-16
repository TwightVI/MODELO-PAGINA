<?php
$pageTitle = 'Inicio';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="hero" id="inicio">
    <div class="container hero-content">
        <p class="eyebrow"><?= e(APP_TAGLINE) ?></p>
    <h1>Tu negocio,<br><em>en un solo lugar.</em></h1>
    <p><?= e(APP_DESCRIPTION) ?></p>
    <a class="button button-dark" href="<?= route('products') ?>">Explorar catálogo <span>→</span></a>
    </div>
    <div class="hero-shape" aria-hidden="true"><span>MARCA<br>DE TU<br>TIENDA</span></div>
</section>
<section class="benefits" aria-label="Funciones de la tienda">
    <div class="container benefits-grid">
    <article><span>✦</span><div><strong>Catálogo organizado</strong><small>Productos ordenados por categoría</small></div></article>
    <article><span>⌕</span><div><strong>Búsqueda integrada</strong><small>Encontrá productos rápidamente</small></div></article>
    <article><span>◉</span><div><strong>Cuenta de cliente</strong><small>Registro e inicio de sesión</small></div></article>
    <article><span>⚙</span><div><strong>Panel administrador</strong><small>Gestioná el catálogo de tu tienda</small></div></article>
    </div>
</section>
<section class="section container" id="categorias">
    <div class="section-heading"><div><p class="eyebrow">Explorá la tienda</p><h2>Categorías</h2></div><a href="<?= route('products') ?>">Ver catálogo →</a></div>
    <div class="category-grid">
        <?php foreach ($categories as $index => $category): ?>
            <a class="category-card" href="<?= route('products', ['category' => $category['id']]) ?>">
                <span class="category-number">0<?= $index + 1 ?></span>
                <h3><?= e($category['name']) ?></h3><p><?= e($category['description']) ?></p>
            </a>
        <?php endforeach; ?>
        <?php if ($categories === []): ?><p class="empty-state">Las categorías aparecerán aquí cuando estén configuradas.</p><?php endif; ?>
    </div>
</section>
<section class="section products-section">
    <div class="container">
        <div class="section-heading"><div><p class="eyebrow">Tu catálogo</p><h2>Productos destacados</h2></div><a href="<?= route('products') ?>">Ver catálogo →</a></div>
        <?php require APP_ROOT . '/app/views/partials/product-grid.php'; ?>
    </div>
</section>
<section class="about container">
    <div><p class="eyebrow">Una base para tu marca</p><h2>Tu identidad,<br>tus productos.</h2></div>
    <div class="about-details">
        <p>Personalizá los textos, colores, categorías y productos para representar tu negocio. Esta plantilla incluye las vistas y herramientas para empezar.</p>
        <a class="button button-dark" href="<?= route('about') ?>">Conocé el modelo <span>→</span></a>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
