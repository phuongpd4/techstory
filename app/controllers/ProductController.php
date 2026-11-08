<?php

class ProductController extends Controller
{
    public function index(): void
    {
        $filters = [
            'category'  => trim($_GET['category'] ?? ''),
            'brand'     => trim($_GET['brand'] ?? ''),
            'q'         => trim($_GET['q'] ?? ''),
            'min_price' => $_GET['min_price'] ?? '',
            'max_price' => $_GET['max_price'] ?? '',
            'sort'      => $_GET['sort'] ?? '',
        ];

        $this->render('products/index', [
            'title'      => 'Danh sách sản phẩm',
            'categories' => Category::all(),
            'brands'     => Brand::all(),
            'products'   => Product::filter($filters),
            'filters'    => $filters,
        ]);
    }
}