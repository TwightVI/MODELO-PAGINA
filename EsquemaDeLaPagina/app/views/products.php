<?php
$pageTitle = 'Productos';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="section products-section catalog-page">
    <div class="container">
        <div class="section-heading"><div><p class="eyebrow">Catálogo</p><h1 class="page-title">Productos</h1></div><p class="catalog-count"><?= count($products) ?> productos encontrados</p></div>
        <form class="catalog-tools" action="<?= route('products') ?>" method="get">
            <input type="hidden" name="page" value="products">
            <label>Buscar <input type="search" name="q" value="<?= e($search) ?>" placeholder="Nombre o descripción"></label>
            <label>Categoría
                <select name="category">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>" <?= $selectedCategory === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="button button-dark" type="submit">Aplicar filtros</button>
            <?php if ($search !== '' || $selectedCategory !== null): ?><a class="clear-filters" href="<?= route('products') ?>">Limpiar</a><?php endif; ?>
        </form>
        <?php require APP_ROOT . '/app/views/partials/product-grid.php'; ?>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
