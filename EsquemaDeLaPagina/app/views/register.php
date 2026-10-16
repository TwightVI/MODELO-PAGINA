<?php
$pageTitle = 'Crear cuenta';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="auth-section container">
    <div class="auth-card">
        <p class="eyebrow">Comprá y seguí tus pedidos</p><h1>Crear cuenta</h1>
        <form method="post" action="<?= route('register') ?>" class="stack-form">
            <?= csrf_field() ?><input type="hidden" name="action" value="register">
            <label>Nombre y apellido<input name="name" type="text" autocomplete="name" required maxlength="120" value="<?= e($values['name']) ?>"></label>
            <label>Correo electrónico<input name="email" type="email" autocomplete="email" required value="<?= e($values['email']) ?>"></label>
            <label>Contraseña<input name="password" type="password" autocomplete="new-password" minlength="6" required></label>
            <label>Repetir contraseña<input name="password_confirmation" type="password" autocomplete="new-password" minlength="6" required></label>
            <button class="button button-dark" type="submit">Crear mi cuenta</button>
        </form>
        <p class="auth-alternate">¿Ya tenés cuenta? <a href="<?= route('login') ?>">Iniciar sesión</a></p>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
