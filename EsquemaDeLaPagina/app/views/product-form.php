<?php
$pageTitle = isset($product['id']) ? 'Editar producto' : 'Nuevo producto';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="auth-section container">
    <div class="auth-card auth-card-wide"><p class="eyebrow">Administración</p><h1><?= isset($product['id']) ? 'Editar producto' : 'Nuevo producto' ?></h1>
        <form action="<?= route('save-product') ?>" method="post" class="stack-form">
            <?= csrf_field() ?><input type="hidden" name="action" value="save-product">
            <?php if (isset($product['id'])): ?><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><?php endif; ?>
            <label>Nombre<input name="name" maxlength="160" required value="<?= e($product['name']) ?>"></label>
            <label>Categoría<select name="category_id" required><option value="">Elegí una categoría</option>
                <?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (int) $product['category_id'] === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option><?php endforeach; ?>
            </select></label>
            <label>Descripción<textarea name="description" rows="4"><?= e($product['description']) ?></textarea></label>
            <label>Precio<input name="price" type="number" min="0" step="0.01" required value="<?= e($product['price']) ?>"></label>
            <label>URL de imagen<input name="image_url" type="url" required value="<?= e($product['image_url']) ?>" placeholder="https://..."></label>
            <label class="checkbox-label"><input type="checkbox" name="is_featured" value="1" <?= (int) $product['is_featured'] === 1 ? 'checked' : '' ?>> Mostrar como destacado</label>
            <label class="checkbox-label"><input type="checkbox" name="is_active" value="1" <?= (int) $product['is_active'] === 1 ? 'checked' : '' ?>> Publicado en la tienda</label>
            <div class="form-actions"><button class="button button-dark" type="submit">Guardar producto</button><a href="<?= route('admin') ?>">Cancelar</a></div>
        </form>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
