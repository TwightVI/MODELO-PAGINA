<?php
$pageTitle = 'Pedido de demostración';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="auth-section container">
    <div class="auth-card checkout-success"><span class="success-mark">✓</span><p class="eyebrow">Checkout de demostración</p><h1>¡Listo!</h1>
        <p>El flujo de compra terminó correctamente en esta plantilla. No se procesó un pago ni se envió un pedido. Conectá aquí el checkout y la operación que necesite el próximo negocio.</p>
        <a class="button button-dark" href="<?= route('products') ?>">Volver al catálogo</a>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
