<?php

class AdminController extends Controller
{
    // Hiển thị thống kê và danh sách đơn hàng
    public function dashboard(): void
    {
        require_admin();
        $this->render('admin/dashboard',[
            'title' => 'Quản trị hệ thống',
            'stats' => Order::stats(),
            'orders' => Order::all(),
            'msg' => $_SESSION['admin_msg'] ?? null,]);

         unset($_SESSION['admin_msg']);
    }
    
    // Đổi trạng thái đơn hàng
    public function updateOrderStatus(): void
    {
        require_admin();
        verify_csrf();

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if($orderId > 0){
            Order::updateStatus($orderId, $status);
            $_SESSION['admin_msg'] = 'Đã cập nhật trạng thái đơn hàng ' . $orderId;
        }
        $this->redirect('/admin');
    }

    public function products(): void
    {
        require_admin();
        $this->render('admin/products',[
            'title' => 'Quản lý sản phẩm',
            'products' => Product::adminALL(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'msg' => $_SESSION['admin_msg'] ?? null,
            'error' => $_SESSION['admin_err'] ?? null,
        ]);
        unset($_SESSION['admin_msg'], $_SESSION['admin_err']);
    }
    // Xử lý lưu sản phẩm mới
    public function storeProduct() : void {
        require_admin();
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $modelCode = trim($_POST['model_code'] ?? '');
        $sku = trim($_POST['sku'] ?? '');
        $price = (int)($_POST['price'] ?? 0);

        if($name === '' || $modelCode === '' || $sku === '' || $price <= 0)
            {
                $_SESSION['admin_err'] = 'Vui lòng nhập đầy đủ thông tin sản phẩm';
                $this->redirect('/admin/san-pham');
            }

        try{
            Product::createWithDefaultVariant([
                    'category_id' => $_POST['category_id'] ?? 1,
                    'brand_id' => $_POST['brand_id'] ?? 1,
                    'name' => $name,
                    'model_code' => $modelCode,
                    'short_desc' => trim($_POST['short_desc'] ?? ''),
                    'description' => trim($_POST['description'] ?? ''),
                    'selling_points' => trim($_POST['selling_points'] ?? ''),
                    'warranty_months' => $_POST['warranty_months'] ?? 12,
                    'sku' => $sku,
                    'color' => trim($_POST['color'] ?? 'Đen'),
                    'color_hex' => trim($_POST['color_hex'] ?? '#1C1C1E'),
                    'ram' => trim($_POST['ram'] ?? ''),
                    'storage' => trim($_POST['storage'] ?? ''),
                    'price' => $price,
                    'sale_price' => $_POST['sale_price'] ?? null,
                    'stock' => $_POST['stock'] ?? 10,
                    'image_url' => trim($_POST['image_url'] ?? ''),
            ]);
            $_SESSION['admin_msg'] = 'Đã thêm sản phẩm "'. $name  . '" thành công!';
        } catch (Throwable $e){
            $_SESSION['admin_err'] = 'Lỗi khi thêm sản phẩm: ' . $e->getMessage();
        }
        $this->redirect('/admin/san-pham');
    }

    //Xem danh sách biến thể của 1 sản phẩm
    public function variants(string $id):void
    {
        require_admin();

        $product = Product::findByID((int)$id);
        if(!$product)
            {
                http_response_code(404);
                echo '404 - Không tìm thấy sản phẩm';
                return;
            }
        $this->render('admin/variants',[
            'title' => 'Biến thể: ' . $product['name'],
            'product' => $product,
            'variants' => Product::variants((int)$product['id']),
            'msg' => $_SESSION['admin_msg'] ?? null,
            'error' => $_SESSION['admin_err'] ?? null,
        ]);
        unset($_SESSION['admin_msg'], $_SESSION['admin_err']);    
    }

    // Hứng dữ liệu form thêm biến thể và xử lý upload ảnh
    public function storeVariant(string $id) : void
    {    
        require_admin();
        verify_csrf();

        $product = Product::findByID((int)$id);
        if(!$product)
            {
                $this->redirect('/admin/san-pham');
            }

            $sku = strtoupper(trim($_POST['sku'] ?? ''));
            $color = trim($_POST['color'] ?? '');
            $price = (int)($_POST['price'] ?? 0);
            if($sku === '' || $color === '' || $price <= 0)
            {
                $_SESSION['admin_err'] = 'Vui lòng nhập đủ mã SKU, màu sắc và giá gốc';
                $this->redirect('/admin/san-pham/' . (int)$product['id'] . '/bien-the');
            }
            // Xử lý ảnh: ưu tiên 1 là file upload từ máy tính
            $imagePath = trim($_POST['image_url'] ?? '');
            $colorHex = trim($_POST['color_hex'] ?? '#1C1C1E');
            if(!empty($_FILES['image_file']['tmp_name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK)
            {
                $tmpFile = $_FILES['image_file']['tmp_name'];
                $mime = mime_content_type($tmpFile);
                $allowed = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'

                ];
                if(!isset($allowed[$mime])){
                    $_SESSION['admin_err'] = 'Chỉ chấp nhận file ảnh JPG, PNG, WebP';
                    $this->redirect('/admin/san-pham/' . (int)$product['id'] . '/bien-the');
                }
                $uploadDir = ROOT. '/public/uploads/products';
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = strtolower($sku) . '_01_front.' . $allowed[$mime];
                move_uploaded_file($tmpFile, $uploadDir . '/' . $fileName);
                $imagePath = '/uploads/products/' . $fileName;

                }
                if($imagePath === ''){
                    $hexClean = ltrim($colorHex, '#');
                    $text = urlencode($product['name'] . ' (' . $color . ')');
                    $imagePath = "https://placehold.co/600x600/{$hexClean}/FFFFFF?text={$text}";                }
            
            try{
                Product::addVariant((int)$product['id'],[
                    'sku' => $sku,
                    'color' => $color,
                    'color_hex' => $colorHex,
                    'ram' =>trim($_POST['ram'] ?? ''),
                    'storage' => trim($_POST['storage'] ?? ''),
                    'price' => $price,
                    'sale_price' => $_POST['sale_price'] ?? null,
                    'stock' => $_POST['stock'] ?? 10,
                    'image_path' => $imagePath,
                    'product_name' => $product['name'],
                ]);
                $_SESSION['admin_msg'] = 'Đã thêm biến thể màu "' . $color . '" thành công';

            }catch(Throwable $e){
                $_SESSION['admin_err'] = 'Lỗi: ' . $e->getMessage();
            }
            $this->redirect('/admin/san-pham/' . (int)$product['id'] . '/bien-the');
    }
}