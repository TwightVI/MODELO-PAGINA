<?php
$pageTitle = 'Página no encontrada';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="auth-section container"><div class="auth-card"><p class="eyebrow">404</p><h1>No encontramos esa página.</h1><a class="button button-dark" href="<?= route('home') ?>">Volver al inicio</a></div></section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
