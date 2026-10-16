<?php $user = current_user(); ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e(APP_DESCRIPTION) ?>">
    <title><?= e($pageTitle ?? APP_NAME) ?> | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="announcement">Modelo de tienda online <span>•</span> Personalizable para tu negocio</div>
<header class="site-header">
    <div class="header-main container">
        <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false">☰</button>
        <a class="brand" href="<?= route('home') ?>" aria-label="<?= e(APP_NAME) ?>, inicio">
            <?php if (APP_LOGO_URL !== ''): ?>
                <img src="<?= e(APP_LOGO_URL) ?>" alt="<?= e(APP_NAME) ?>" fetchpriority="high">
            <?php else: ?>
                <span class="brand-mark" aria-hidden="true">T</span><strong><?= e(APP_NAME) ?></strong>
            <?php endif; ?>
        </a>
        <form class="search" action="<?= route('products') ?>" method="get" role="search">
            <input type="hidden" name="page" value="products">
            <label class="sr-only" for="search-input">Buscar productos</label>
            <input id="search-input" type="search" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="¿Qué estás buscando?">
            <button type="submit" aria-label="Buscar">⌕</button>
        </form>
        <?php if ($user !== null): ?>
            <a class="cart-button" href="<?= route('checkout') ?>" aria-label="Ver carrito">🛒 Carrito <b><?= cart_count() ?></b></a>
        <?php else: ?>
            <a class="cart-button" href="<?= route('login') ?>" aria-label="Iniciar sesión para usar el carrito">🛒 Carrito <b><?= cart_count() ?></b></a>
        <?php endif; ?>
    </div>
    <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
        <div class="container nav-links">
            <a href="<?= route('home') ?>">Inicio</a>
            <a href="<?= route('products') ?>">Productos</a>
            <a href="<?= route('about') ?>">Quiénes somos</a>
            <?php if (($user['role'] ?? null) === 'admin'): ?>
                <a href="<?= route('admin') ?>">Administrar</a>
            <?php endif; ?>
            <?php if ($user === null): ?>
                <a href="<?= route('login') ?>">Ingresar</a><a href="<?= route('register') ?>">Crear cuenta</a>
            <?php else: ?>
                <span class="nav-welcome">Hola, <?= e($user['name']) ?></span>
                <form action="<?= route('home') ?>" method="post" class="inline-form"><?= csrf_field() ?><input type="hidden" name="action" value="logout"><button class="nav-button" type="submit">Cerrar sesión</button></form>
            <?php endif; ?>
        </div>
    </nav>
</header>
<main>
    <div class="container notices" aria-live="polite">
        <?php foreach (['success', 'error'] as $noticeType): ?>
            <?php if ($message = flash($noticeType)): ?>
                <p class="notice notice-<?= e($noticeType) ?>"><?= e($message) ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
