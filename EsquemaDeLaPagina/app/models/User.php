<?php
declare(strict_types=1);

final class User
{
    public static function findByEmail(string $email): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, name, email, password_hash, role FROM users WHERE email = :email LIMIT 1'
        );
        $statement->execute(['email' => strtolower(trim($email))]);
        $user = $statement->fetch();
        return $user ?: null;
    }

    public static function create(string $name, string $email, string $password): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO users (name, email, password_hash, role)
             VALUES (:name, :email, :password_hash, \'customer\')'
        );
        $statement->execute([
            'name' => trim($name),
            'email' => strtolower(trim($email)),
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
}
