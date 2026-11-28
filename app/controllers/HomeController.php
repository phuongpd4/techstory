<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::popular();
        $brands     = Brand::all();
        $products   = Product::featured(6); 
        $this->render('home/index', [
            'title' => 'Trang chủ',
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
        ]);
    }
    public function sitemap() : void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        echo " <url><loc>{$base}/</loc></url>\n";
        echo " <url><loc>{$base}/san-pham</loc></url>\n";
        foreach (Product::filter() as $p){
            echo " <url><loc>{$base}/san-pham/" . e($p['slug']) . "</loc></url>\n";
        }
        echo '</urlset>';   
    }
}