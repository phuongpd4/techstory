# TechStore — Website Bán Hàng Công Nghệ (PHP 8 MVC + MySQL)

Website thương mại điện tử bán lẻ sản phẩm công nghệ (Điện thoại, Laptop, Máy tính bảng, Tai nghe, Đồng hồ thông minh, Phụ kiện) xây dựng bằng **PHP 8 thuần (MVC)**, **MySQL (PDO)** và **Bootstrap 5**.

## Tính năng chính
- **Cửa hàng**: Trang chủ Showroom, tìm kiếm & lọc sản phẩm, chi tiết sản phẩm đổi biến thể động (màu sắc/RAM/bộ nhớ), Gallery nhiều góc chụp & Video MP4, So sánh cấu hình, Đánh giá 5 sao.
- **Mua sắm & Thanh toán**: Giỏ hàng, Mã giảm giá, Đặt hàng Transaction trừ kho an toàn (`FOR UPDATE`), thanh toán **COD** & **VietQR** tự động điền số tiền + đồng hồ giữ đơn 15 phút.
- **Tài khoản**: Đăng ký/Đăng nhập (`password_hash`), Lịch sử đơn hàng & Tự hủy hoàn kho, Yêu thích, Sổ địa chỉ.
- **Quản trị (`/admin`)**: Thống kê KPI & Biểu đồ doanh thu (`Chart.js`), quản lý Đơn hàng, Sản phẩm, Biến thể, Upload ảnh/video `.mp4`, Mã giảm giá.
- **Bảo mật & SEO**: PDO Prepared Statements, CSRF Token, chống XSS, MIME upload check, Meta OpenGraph, `Schema.org Product`, `robots.txt`, `/sitemap.xml`.

## Cài đặt Localhost
1. Bật MySQL trong XAMPP, tạo CSDL `techstore` và import `database/schema.sql`, `database/seed.sql`.
2. Cấu hình kết nối DB trong `app/config/config.php`.
3. Chạy server: `php -S localhost:8000 -t public public/index.php`
4. Mở `http://localhost:8000` (Admin mẫu: `admin@techstore.vn` / `password`).