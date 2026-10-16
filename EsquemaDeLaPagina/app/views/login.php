<?php
$pageTitle = 'Iniciar sesión';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="auth-section container">
    <div class="auth-card">
        <p class="eyebrow">Tu cuenta</p><h1>Iniciar sesión</h1>
        <form method="post" action="<?= route('login') ?>" class="stack-form">
            <?= csrf_field() ?><input type="hidden" name="action" value="login">
            <label>Correo electrónico<input name="email" type="email" autocomplete="email" required value="<?= e($_POST['email'] ?? '') ?>"></label>
            <label>Contraseña<input name="password" type="password" autocomplete="current-password" required></label>
            <button class="button button-dark" type="submit">Ingresar</button>
        </form>
        <p class="auth-alternate">¿Todavía no tenés cuenta? <a href="<?= route('register') ?>">Crear cuenta</a></p>
        <p class="demo-note"><strong>Acceso administrador de demostración</strong><br>Usuario: admin@tienda.local<br>Contraseña: admin123</p>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
