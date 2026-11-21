# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users
Khách hàng phổ thông và người yêu công nghệ trẻ (18–35 tuổi) tại Việt Nam tìm mua điện thoại, laptop, máy tính bảng, tai nghe, đồng hồ thông minh và phụ kiện chính hãng. Họ muốn xem hình ảnh đa góc sắc nét, so sánh cấu hình nhanh và đặt hàng online tiện lợi.

## Product Purpose
TechStore là website thương mại điện tử bán lẻ sản phẩm công nghệ (PHP 8 MVC + MySQL + Bootstrap 5) cho phép khách hàng khám phá sản phẩm, chọn biến thể màu sắc/cấu hình trực quan, so sánh thông số và thanh toán nhanh qua COD hoặc VietQR.

## Positioning
Trải nghiệm trưng bày sản phẩm cao cấp, tối giản và sang trọng như một showroom công nghệ thực thụ — tập trung tôn vinh sản phẩm và thông số rõ ràng thay vì giao diện rối rắm nhiều banner giảm giá.

## Operating Context
- Máy chủ phát triển: PHP 8.5 built-in server (`php -S localhost:8000 -t public public/index.php`) + MySQL XAMPP.
- Dự kiến triển khai trên Hosting Apache/LiteSpeed + tên miền thật với HTTPS.
- Người dùng tự tay gõ mã nguồn ứng dụng theo từng đoạn ngắn (5–10 dòng/lần) để nắm chắc kiến thức.

## Capabilities and Constraints
- Đã hoàn thiện đầy đủ chức năng: Trang chủ, Lọc/Tìm kiếm (`/san-pham`), Chi tiết sản phẩm kèm biến thể động & Gallery/Video (`/san-pham/{slug}`), So sánh (`/so-sanh`), Giỏ hàng & Mã giảm giá (`/gio-hang`), Checkout COD & VietQR (`/thanh-toan`), Tài khoản (Đơn mua, Yêu thích, Sổ địa chỉ), Admin Dashboard + Biểu đồ + CRUD Sản phẩm/Biến thể/Media/Mã giảm giá, SEO (Meta OG, Schema.org, `sitemap.xml`, `robots.txt`).
- Stack hiện có: PHP 8 thuần (MVC), Bootstrap 5.3 CDN, Bootstrap Icons, custom CSS tại `public/assets/css/style.css`.

## Brand Commitments
- Tên thương hiệu: **TechStore**
- Các thương hiệu sản phẩm trong cửa hàng: Nova, Zenith, Aurora.
- Ngôn ngữ hiển thị: Tiếng Việt.

## Evidence on Hand
- 37 tấm ảnh chụp Studio & Lifestyle AI lưu tại `public/uploads/products/` cho 13 sản phẩm thuộc 7 danh mục.
- Không bịa thêm đánh giá giả, chứng nhận giả hoặc số liệu khách hàng không có trong CSDL.

## Product Principles
1. **Sản phẩm là trung tâm**: Mọi bề mặt và khoảng trắng đều phục vụ việc tôn vinh hình ảnh studio và thông số sản phẩm.
2. **Tối giản kiểu showroom công nghệ**: Tránh nhồi nhét màu sắc chói, gradient thừa hay thẻ lồng trong thẻ.
3. **Nhanh và rõ ràng khi ra quyết định**: Giá bán, biến thể màu/dung lượng, tồn kho và nút hành động luôn dễ quét mắt trong 3 giây.
4. **Nhất quán giữa cửa hàng và trải nghiệm mua**: Từ trang chủ, danh sách, chi tiết đến giỏ hàng đều giữ chung một ngôn ngữ thiết kế tinh tế.
