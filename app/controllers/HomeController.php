<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::all(); 
        $this->render('home/index', [
            'title' => 'Trang chủ',
            'categories' => $categories,
        ]);
    }
}