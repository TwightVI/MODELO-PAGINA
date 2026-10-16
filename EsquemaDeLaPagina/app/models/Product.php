<?php
declare(strict_types=1);

final class Product
{
    public static function categories(): array
    {
        return Database::connection()
            ->query('SELECT id, name, description FROM categories ORDER BY sort_order, name')
            ->fetchAll();
    }

    public static function all(string $search = '', ?int $categoryId = null, ?int $limit = null): array
    {
        $sql = 'SELECT p.*, c.name AS category_name
                FROM products p
                INNER JOIN categories c ON c.id = p.category_id
                WHERE p.is_active = 1';
        $parameters = [];

        if ($search !== '') {
            $sql .= ' AND (p.name LIKE :name_search OR p.description LIKE :description_search OR c.name LIKE :category_search)';
            $searchPattern = '%' . $search . '%';
            $parameters['name_search'] = $searchPattern;
            $parameters['description_search'] = $searchPattern;
            $parameters['category_search'] = $searchPattern;
        }
        if ($categoryId !== null) {
            $sql .= ' AND p.category_id = :category_id';
            $parameters['category_id'] = $categoryId;
        }
        $sql .= ' ORDER BY p.is_featured DESC, c.sort_order, p.name';
        if ($limit !== null) {
            $sql .= ' LIMIT ' . max(1, $limit);
        }

        $statement = Database::connection()->prepare($sql);
        $statement->execute($parameters);
        return $statement->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             INNER JOIN categories c ON c.id = p.category_id WHERE p.id = :id'
        );
        $statement->execute(['id' => $id]);
        $product = $statement->fetch();
        return $product ?: null;
    }

    public static function cartItems(array $cart): array
    {
        $ids = array_map('intval', array_keys($cart));
        if ($ids === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $statement = Database::connection()->prepare(
            "SELECT id, name, price, image_url FROM products WHERE is_active = 1 AND id IN ($placeholders)"
        );
        $statement->execute($ids);
        $products = [];

        foreach ($statement->fetchAll() as $product) {
            $quantity = max(1, (int) ($cart[$product['id']] ?? 1));
            $product['quantity'] = $quantity;
            $product['subtotal'] = (float) $product['price'] * $quantity;
            $products[] = $product;
        }

        return $products;
    }

    public static function save(array $data, ?int $id = null): void
    {
        $parameters = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image_url' => $data['image_url'],
            'is_featured' => $data['is_featured'],
            'is_active' => $data['is_active'],
        ];

        if ($id === null) {
            $statement = Database::connection()->prepare(
                'INSERT INTO products (category_id, name, description, price, image_url, is_featured, is_active)
                 VALUES (:category_id, :name, :description, :price, :image_url, :is_featured, :is_active)'
            );
        } else {
            $parameters['id'] = $id;
            $statement = Database::connection()->prepare(
                'UPDATE products SET category_id = :category_id, name = :name, description = :description,
                 price = :price, image_url = :image_url, is_featured = :is_featured, is_active = :is_active
                 WHERE id = :id'
            );
        }

        $statement->execute($parameters);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
