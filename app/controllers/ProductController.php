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

    public function show(string $slug): void
    {
        $product = Product::findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            echo '404 - Sản phẩm không tồn tại';
            return;
        }

        $variants = Product::variants((int)$product['id']);
        $specs    = Product::specs((int)$product['id']);
        $reviews = Review::byProduct((int)$product['id']);
        $this->render('products/show', [
            'title'    => $product['name'],
            'product'  => $product,
            'variants' => $variants,
            'specs'    => $specs,
            'reviews' => $reviews
        ]);
    }
    // Nhân dữ liệu khi khách bấm gửi đánh giá
    public function storeReview(string $slug):void
    {
        verify_csrf();
        $user = current_user();
        if(!$user){
            $this->redirect('/dang-nhap');
        }
        $product = Product::findBySlug($slug);
        $rating = (int)($_POST['rating'] ?? 5);
        $content = trim($_POST['content'] ?? '');

        if($product && $content !== ''){
            Review::create((int)$product['id'],
            (int)$user['id'], $rating, $content);
        }
        $this->redirect('/san-pham/' . $slug);
    }
}