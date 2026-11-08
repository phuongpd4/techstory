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
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);