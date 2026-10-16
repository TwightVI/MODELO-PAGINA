<?php if ($products === []): ?>
    <p class="empty-state">Todavía no hay productos publicados. El catálogo aparecerá aquí cuando agregues productos.</p>
<?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <?php if ((int) ($product['is_featured'] ?? 0) === 1): ?><span class="tag">DESTACADO</span><?php endif; ?>
                <div class="product-image"><img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" loading="lazy"></div>
                <div class="product-info">
                    <p class="product-category"><?= e($product['category_name']) ?></p>
                    <h3><?= e($product['name']) ?></h3>
                    <p class="product-description"><?= e($product['description']) ?></p>
                    <p class="product-price"><?= e('$' . number_format((float) $product['price'], 2, ',', '.')) ?></p>
                    <?php if (current_user() !== null): ?>
                        <form action="<?= route('add-to-cart') ?>" method="post">
                            <?= csrf_field() ?><input type="hidden" name="action" value="add-to-cart"><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                            <input type="hidden" name="return_to" value="<?= e($_GET['page'] ?? 'products') ?>">
                            <button class="add-button" type="submit">Agregar al carrito +</button>
                        </form>
                    <?php else: ?>
                        <a class="add-button add-link" href="<?= route('login') ?>">Ingresá para comprar +</a>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
