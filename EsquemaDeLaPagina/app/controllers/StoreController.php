<?php
declare(strict_types=1);

final class StoreController
{
    public static function home(): void
    {
        render_view('home', [
            'categories' => Product::categories(),
            'products' => Product::all(limit: 4),
        ]);
    }

    public static function products(): void
    {
        $search = trim((string) ($_GET['q'] ?? ''));
        $categoryId = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
        render_view('products', [
            'categories' => Product::categories(),
            'products' => Product::all($search, $categoryId ?: null),
            'search' => $search,
            'selectedCategory' => $categoryId ?: null,
        ]);
    }

    public static function about(): void
    {
        render_view('about');
    }

    public static function cart(): void
    {
        require_login();
        render_view('checkout', ['items' => Product::cartItems($_SESSION['cart'] ?? [])]);
    }

    public static function completeCheckout(): void
    {
        require_login();
        if (Product::cartItems($_SESSION['cart'] ?? []) === []) {
            flash('error', 'Tu carrito está vacío.');
            redirect('products');
        }

        $_SESSION['cart'] = [];
        redirect('checkout-complete');
    }

    public static function addToCart(): void
    {
        require_login();
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product = $productId ? Product::find($productId) : null;

        if ($product === null || (int) $product['is_active'] !== 1) {
            flash('error', 'El producto ya no está disponible.');
            redirect('products');
        }

        $cart = $_SESSION['cart'] ?? [];
        $cart[$productId] = min(99, (int) ($cart[$productId] ?? 0) + 1);
        $_SESSION['cart'] = $cart;
        flash('success', 'Se agregó «' . $product['name'] . '» al carrito.');
        redirect((string) ($_POST['return_to'] ?? 'products'));
    }

    public static function updateCart(): void
    {
        require_login();
        $cart = $_SESSION['cart'] ?? [];
        $quantities = $_POST['quantities'] ?? null;
        if (!is_array($quantities) || $quantities === []) {
            flash('error', 'No se recibieron cantidades para actualizar.');
            redirect('checkout');
        }

        foreach ($quantities as $id => $quantity) {
            $productId = filter_var($id, FILTER_VALIDATE_INT);
            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if (!$productId || !isset($cart[$productId]) || $quantity === false || $quantity < 0 || $quantity > 99) {
                flash('error', 'Una de las cantidades no es válida. Revisá el carrito e intentá otra vez.');
                redirect('checkout');
            }
        }

        foreach ($quantities as $id => $quantity) {
            $productId = (int) $id;
            $quantity = (int) $quantity;
            if ($quantity < 1) {
                unset($cart[$productId]);
            } else {
                $cart[$productId] = $quantity;
            }
        }
        $_SESSION['cart'] = $cart;
        flash('success', 'Se actualizó tu carrito.');
        redirect('checkout');
    }

    public static function removeFromCart(): void
    {
        require_login();
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        if (!$productId || !isset($_SESSION['cart'][$productId])) {
            flash('error', 'No se encontró ese artículo en el carrito.');
            redirect('checkout');
        }
        unset($_SESSION['cart'][$productId]);
        redirect('checkout');
    }
}
