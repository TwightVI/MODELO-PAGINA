<?php
$pageTitle = 'Tu carrito';
require APP_ROOT . '/app/views/partials/header.php';
$total = array_sum(array_column($items, 'subtotal'));
?>
<section class="section container checkout-page">
    <p class="eyebrow">Tu compra</p><h1 class="page-title">Carrito</h1>
    <?php if ($items === []): ?>
        <div class="empty-state"><p>Tu carrito está vacío.</p><a class="button button-dark" href="<?= route('products') ?>">Explorar productos</a></div>
    <?php else: ?>
            <div class="cart-table">
                <?php foreach ($items as $item): ?>
                    <form action="<?= route('checkout') ?>" method="post" class="cart-row">
                        <?= csrf_field() ?><input type="hidden" name="action" value="update-cart"><input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                        <img src="<?= e($item['image_url']) ?>" alt="">
                        <div class="cart-product"><strong><?= e($item['name']) ?></strong><span><?= e('$' . number_format((float) $item['price'], 2, ',', '.')) ?> c/u</span></div>
                        <label class="quantity-label">Cantidad<input type="number" name="quantities[<?= (int) $item['id'] ?>]" value="<?= (int) $item['quantity'] ?>" min="0" max="99"></label>
                        <strong><?= e('$' . number_format((float) $item['subtotal'], 2, ',', '.')) ?></strong>
                        <div class="cart-row-actions"><button class="text-button" type="submit">Actualizar</button><button class="text-button" type="submit" name="action" value="remove-from-cart">Quitar</button></div>
                    </form>
                <?php endforeach; ?>
            </div>
            <div class="cart-actions"><a href="<?= route('products') ?>">Seguir comprando</a></div>
        <div class="checkout-total"><span>Total</span><strong><?= e('$' . number_format((float) $total, 2, ',', '.')) ?></strong></div>
        <div class="checkout-disclaimer"><strong>Checkout de demostración</strong><p>Este modelo no procesa pagos ni envía pedidos. Al confirmar, muestra el punto de integración que cada negocio puede conectar con su proveedor de pagos o sistema de ventas.</p>
            <form action="<?= route('finish-checkout') ?>" method="post"><?= csrf_field() ?><input type="hidden" name="action" value="finish-checkout"><button class="button button-dark" type="submit">Confirmar pedido de demostración</button></form>
        </div>
    <?php endif; ?>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
