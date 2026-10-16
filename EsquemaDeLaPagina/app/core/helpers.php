<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function route_url(string $page = 'home', array $parameters = []): string
{
    $parameters = ['page' => $page] + $parameters;
    return $_SERVER['SCRIPT_NAME'] . '?' . http_build_query($parameters);
}

function route(string $page = 'home', array $parameters = []): string
{
    return e(route_url($page, $parameters));
}

function redirect(string $page, array $parameters = []): never
{
    header('Location: ' . route_url($page, $parameters));
    exit;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $stored = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $stored;
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $submitted = $_POST['csrf_token'] ?? '';
    if (!is_string($submitted) || !hash_equals(csrf_token(), $submitted)) {
        http_response_code(400);
        exit('La sesión del formulario venció. Volvé a cargar la página e intentá otra vez.');
    }
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (current_user() === null) {
        flash('error', 'Iniciá sesión para usar el carrito.');
        redirect('login');
    }
}

function require_admin(): void
{
    if ((current_user()['role'] ?? null) !== 'admin') {
        flash('error', 'Esta sección está disponible solo para administración.');
        redirect(current_user() === null ? 'login' : 'home');
    }
}

function cart_count(): int
{
    return array_sum($_SESSION['cart'] ?? []);
}

function render_view(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require APP_ROOT . '/app/views/' . $view . '.php';
}
