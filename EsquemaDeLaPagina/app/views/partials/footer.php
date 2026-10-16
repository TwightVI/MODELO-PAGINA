</main>
<footer id="contacto">
    <div class="container footer-content">
        <a class="brand footer-brand" href="<?= route('home') ?>"><span class="brand-mark" aria-hidden="true">T</span><strong><?= e(APP_NAME) ?></strong></a>
        <p><?= e(APP_DESCRIPTION) ?></p>
        <small>© <?= date('Y') ?> <?= e(APP_NAME) ?> · Plantilla de ecommerce adaptable</small>
    </div>
</footer>
<script>
const menuToggle = document.querySelector('#menu-toggle');
menuToggle?.addEventListener('click', () => {
    const nav = document.querySelector('#main-nav');
    const isOpen = nav.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', String(isOpen));
});
</script>
</body>
</html>
