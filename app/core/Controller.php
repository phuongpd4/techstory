<?php

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layouts/' . $layout . '.php';
    }

    protected function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }
}