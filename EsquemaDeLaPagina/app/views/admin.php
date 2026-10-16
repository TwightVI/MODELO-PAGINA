<?php
$pageTitle = 'Administrar productos';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="section container admin-page">
    <div class="section-heading"><div><p class="eyebrow">Panel de control</p><h1 class="page-title">Productos</h1></div><a class="button button-dark" href="<?= route('product-form') ?>">+ Nuevo producto</a></div>
    <p class="admin-hint">El CRUD de catálogo solo está disponible para la cuenta con rol administrador.</p>
    <?php if ($products === []): ?><p class="empty-state">No hay productos todavía. Creá el primero para publicarlo.</p><?php else: ?>
        <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Producto</th><th>Categoría</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>
            <?php foreach ($products as $product): ?><tr>
                <td><strong><?= e($product['name']) ?></strong></td><td><?= e($product['category_name']) ?></td>
                <td><?= e('$' . number_format((float) $product['price'], 2, ',', '.')) ?></td>
                <td><?= (int) $product['is_active'] === 1 ? 'Publicado' : 'Oculto' ?></td>
                <td class="admin-actions"><a href="<?= route('product-form', ['id' => $product['id']]) ?>">Editar</a>
                    <form action="<?= route('delete-product') ?>" method="post" onsubmit="return confirm('¿Eliminar este producto?')"><?= csrf_field() ?><input type="hidden" name="action" value="delete-product"><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>"><button class="text-button" type="submit">Eliminar</button></form>
                </td>
            </tr><?php endforeach; ?>
        </tbody></table></div>
    <?php endif; ?>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
