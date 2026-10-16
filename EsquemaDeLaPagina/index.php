<?php
declare(strict_types=1);

require __DIR__ . '/config/config.php';
require APP_ROOT . '/app/core/Database.php';
require APP_ROOT . '/app/core/helpers.php';
require APP_ROOT . '/app/models/Product.php';
require APP_ROOT . '/app/models/User.php';
require APP_ROOT . '/app/controllers/StoreController.php';
require APP_ROOT . '/app/controllers/AuthController.php';
require APP_ROOT . '/app/controllers/AdminController.php';

session_start();

try {
    Database::connection();
} catch (PDOException $exception) {
    http_response_code(503);
    $errorMessage = $exception->getMessage();
    require APP_ROOT . '/app/views/setup-error.php';
    exit;
}

$action = (string) ($_POST['action'] ?? '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    switch ($action) {
        case 'login': AuthController::login(); break;
        case 'register': AuthController::register(); break;
        case 'logout': AuthController::logout(); break;
        case 'add-to-cart': StoreController::addToCart(); break;
        case 'update-cart': StoreController::updateCart(); break;
        case 'remove-from-cart': StoreController::removeFromCart(); break;
        case 'finish-checkout': StoreController::completeCheckout(); break;
        case 'save-product': AdminController::saveProduct(); break;
        case 'delete-product': AdminController::deleteProduct(); break;
        default:
            http_response_code(404);
            echo 'Acción no encontrada.';
            exit;
    }
}

$page = (string) ($_GET['page'] ?? 'home');
switch ($page) {
    case 'home': StoreController::home(); break;
    case 'products': StoreController::products(); break;
    case 'about': StoreController::about(); break;
    case 'login': AuthController::login(); break;
    case 'register': AuthController::register(); break;
    case 'checkout': StoreController::cart(); break;
    case 'checkout-complete':
        require_login();
        render_view('checkout-complete');
        break;
    case 'admin': AdminController::dashboard(); break;
    case 'product-form': AdminController::productForm(); break;
    default:
        http_response_code(404);
        render_view('not-found');
}
