<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $products   = Product::featured(6); 
        $this->render('home/index', [
            'title' => 'Trang chủ',
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
        ]);
    }
}