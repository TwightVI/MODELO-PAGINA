<?php
$pageTitle = 'Quiénes somos';
require APP_ROOT . '/app/views/partials/header.php';
?>
<section class="about-page container">
    <div class="about-intro">
        <p class="eyebrow">Acerca de esta plantilla</p>
        <h1>Una tienda<br>que se adapta<br><em>a tu negocio.</em></h1>
        <p>Este modelo reúne la estructura esencial para presentar una marca, organizar un catálogo y ofrecer una experiencia de compra clara.</p>
    </div>
    <div class="about-copy">
        <h2>Un punto de partida flexible</h2>
        <p>La página incluye inicio, catálogo y presentación del negocio, además de registro, inicio de sesión, carrito y un panel privado para administrar productos.</p>
        <p>Los textos, colores, categorías y datos de conexión se pueden adaptar. El catálogo de esta versión está vacío para que puedas imaginar la tienda con tu propio contenido.</p>
        <div class="store-grid">
            <article><span>01 / Presentación</span><h3>Identidad</h3><p>Una portada para comunicar la propuesta de tu negocio.</p></article>
            <article><span>02 / Catálogo</span><h3>Productos</h3><p>Organización por categorías y búsqueda integrada.</p></article>
            <article><span>03 / Gestión</span><h3>Administración</h3><p>Herramientas para publicar, editar y ocultar productos.</p></article>
        </div>
    </div>
</section>
<section class="location-section">
    <div class="container location-grid">
        <div><p class="eyebrow">Personalización</p><h2>Preparada para crecer.</h2>
            <p>Reemplazá los textos de ejemplo, elegí la identidad visual de tu marca y cargá las categorías y los productos de tu negocio.</p>
            <ul class="business-details"><li><strong>Marca:</strong> editable desde la configuración</li><li><strong>Catálogo:</strong> vacío y listo para personalizar</li><li><strong>Compra:</strong> flujo de demostración, sin cobros reales</li></ul>
        </div>
        <div class="model-card"><span class="brand-mark" aria-hidden="true">T</span><p><?= e(APP_NAME) ?></p><small>Tu próxima tienda online</small></div>
    </div>
</section>
<?php require APP_ROOT . '/app/views/partials/footer.php'; ?>
