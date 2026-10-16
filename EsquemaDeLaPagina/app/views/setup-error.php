<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Configurar <?= e(APP_NAME) ?></title><link rel="stylesheet" href="css/style.css"></head>
<body><main class="auth-section container"><section class="auth-card auth-card-wide"><p class="eyebrow">Falta un paso de configuración</p><h1>No se pudo conectar con MySQL</h1>
<p>Revisá que MySQL esté iniciado y que hayas importado <code>database.sql</code> desde phpMyAdmin. La conexión se configura en <code>config/config.php</code>.</p>
<p class="setup-error"><?= e($errorMessage) ?></p></section></main></body></html>
