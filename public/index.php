<?php
declare(strict_types=1); // phát hiện lỗi truyền sai

// Nếu trình duyệt hỏi file tĩnh có thật (css, js, ảnh) thì trả file đó luôn
if (PHP_SAPI === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

session_start();
define('ROOT', dirname(__DIR__));

// Tự động nạp (autoload) các class trong core, controllers, models khi được gọi tên
spl_autoload_register(function (string $class) {
    foreach (['core', 'controllers', 'models'] as $dir) {
        $file = ROOT . "/app/{$dir}/{$class}.php";
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

require ROOT . '/app/helpers/functions.php';
$config = require ROOT . '/app/config/config.php';
Database::connect($config['db']);

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->get('/san-pham', [ProductController::class, 'index']);
$router->get('/san-pham/{slug}', [ProductController::class, 'show']);
$router->get('/dang-nhap', [AuthController::class, 'showLogin']);
$router->post('/dang-nhap', [AuthController::class, 'login']);
$router->get('/dang-ky', [AuthController::class, 'showRegister']);
$router->post('/dang-ky', [AuthController::class, 'register']);
$router->post('/dang-xuat', [AuthController::class, 'logout']);
$router->get('/gio-hang', [CartController::class, 'index']);
$router->post('/gio-hang/them', [CartController::class, 'add']);
$router->post('/gio-hang/cap-nhat', [CartController::class, 'update']);
$router->post('/gio-hang/xoa', [CartController::class, 'remove']);
$router->post('/gio-hang/ma-giam-gia', [CartController::class, 'applyCoupon']);
$router->get('/thanh-toan', [CheckoutController::class, 'index']);
$router->post('/thanh-toan', [CheckoutController::class, 'placeOrder']);
$router->get('/dat-hang-thanh-cong/{code}', [CheckoutController::class, 'success']);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);