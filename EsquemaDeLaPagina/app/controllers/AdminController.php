<?php
declare(strict_types=1);

final class AdminController
{
    public static function dashboard(): void
    {
        require_admin();
        render_view('admin', [
            'products' => self::allProducts(),
            'categories' => Product::categories(),
        ]);
    }

    public static function productForm(): void
    {
        require_admin();
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $product = $id ? Product::find($id) : null;
        if ($id && $product === null) {
            flash('error', 'No se encontró ese producto.');
            redirect('admin');
        }
        render_view('product-form', [
            'product' => $product ?? [
                'name' => '', 'category_id' => '', 'description' => '', 'price' => '',
                'image_url' => '', 'is_featured' => 0, 'is_active' => 1,
            ],
            'categories' => Product::categories(),
        ]);
    }

    public static function saveProduct(): void
    {
        require_admin();
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $categoryId = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT);
        $name = trim((string) ($_POST['name'] ?? ''));
        $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
        $imageUrl = trim((string) ($_POST['image_url'] ?? ''));

        if ($id && Product::find($id) === null) {
            flash('error', 'No se encontró el producto que intentás editar.');
            redirect('admin');
        }
        if ($name === '' || strlen($name) > 160 || !$categoryId || $price === false || $price < 0 || $imageUrl === '') {
            flash('error', 'Completá nombre, categoría, precio válido e imagen.');
            redirect('product-form', $id ? ['id' => $id] : []);
        }
        if (!filter_var($imageUrl, FILTER_VALIDATE_URL) || !in_array(strtolower((string) parse_url($imageUrl, PHP_URL_SCHEME)), ['http', 'https'], true)) {
            flash('error', 'La imagen debe tener una dirección URL válida (http o https).');
            redirect('product-form', $id ? ['id' => $id] : []);
        }
        $categoryExists = false;
        foreach (Product::categories() as $category) {
            if ((int) $category['id'] === $categoryId) {
                $categoryExists = true;
                break;
            }
        }
        if (!$categoryExists) {
            flash('error', 'Seleccioná una categoría disponible.');
            redirect('product-form', $id ? ['id' => $id] : []);
        }

        Product::save([
            'category_id' => $categoryId,
            'name' => $name,
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price' => $price,
            'image_url' => $imageUrl,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ], $id ?: null);

        flash('success', 'El producto se guardó correctamente.');
        redirect('admin');
    }

    public static function deleteProduct(): void
    {
        require_admin();
        $id = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || Product::find($id) === null) {
            flash('error', 'No se encontró el producto que intentás eliminar.');
            redirect('admin');
        }
        Product::delete($id);
        flash('success', 'El producto se eliminó del catálogo.');
        redirect('admin');
    }

    private static function allProducts(): array
    {
        $statement = Database::connection()->query(
            'SELECT p.*, c.name AS category_name FROM products p
             INNER JOIN categories c ON c.id = p.category_id ORDER BY c.sort_order, p.name'
        );
        return $statement->fetchAll();
    }
}
