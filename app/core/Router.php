<?php

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        // Biến '/san-pham/{slug}' thành biểu thức chính quy '#^/san-pham/([^/]+)$#'
        $regex = '#^' . preg_replace('#\{[a-z_]+\}#', '([^/]+)', $path) . '$#';
        $this->routes[] = [$method, $regex, $handler];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH), '/') ?: '/';

        foreach ($this->routes as [$m, $regex, [$class, $action]]) {
            if ($m === $method && preg_match($regex, $path, $params)) {
                array_shift($params);
                (new $class())->$action(...$params);
                return;
            }
        }

        http_response_code(404);
        echo '404 - Không tìm thấy trang';
    }
}