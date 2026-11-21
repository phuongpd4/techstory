# Design System — TechStore (Minimalist Tech Showroom)

## Visual World
**Showroom Công Nghệ Tối Giản (Apple / ThinkPro / Minimalist Industrial)** — tập trung tối đa vào sản phẩm, ảnh chụp studio sắc nét và độ rõ ràng của thông số/giá bán. Tuyệt đối tránh kiểu "AI slop" (gradient tím-xanh, nhãn badge bay trên tiêu đề, thẻ card lồng nhau, màu chói thiếu tương phản).

## Color Palette
- **Canvas (Nền trang)**: `#f8f9fa` (Alabaster dịu mắt, không chói trắng).
- **Surface (Bề mặt thẻ & thanh điều hướng)**: `#ffffff` kết hợp viền mảnh `1px solid #e4e4e7`.
- **Primary Ink (Chữ chính & nút hành động chính)**: `#09090b` (Obsidian — độ tương phản > 18:1 trên nền trắng).
- **Secondary Ink (Chữ phụ/mô tả)**: `#52525b` (Zinc-600 — độ tương phản > 7:1).
- **Accent (Điểm nhấn tương tác)**: `#0052cc` (Cobalt chính xác, chỉ dùng cho link/trạng thái chọn).
- **Price Ink (Giá bán)**: `#d70018` (Đỏ bán lẻ công nghệ rõ nét, luôn dùng `tabular-nums`).

## Typography
- **Font chữ**: `'Plus Jakarta Sans', -apple-system, sans-serif`.
- **Display & Headings**: Trọng lượng `700`, `letter-spacing: -0.025em`, không dùng badge kicker phía trên tiêu đề.
- **Số liệu & Giá bán**: `font-variant-numeric: tabular-nums` để chữ số thẳng hàng.

## Layout & Craft Rules
1. **Header (Thanh điều hướng)**: Nền trắng mờ (`rgba(255,255,255,0.88)` + `backdrop-filter: blur(12px)`), chữ đen sắc nét, viền dưới mảnh `1px solid #e4e4e7` (thay thế hoàn toàn thanh `bg-warning` cũ).
2. **Hero Banner**: Bố cục 2 cột đối xứng nền đen nhám `#0c0c0e` (không dùng gradient tím-xanh), bên trái tiêu đề & nút hành động, bên phải trưng bày trực tiếp ảnh Studio của **Nova X Pro**.
3. **Danh mục & Thương hiệu**: Thanh nút gọn (pill/chip bar) thay vì các ô card to chiếm hết màn hình, đưa sản phẩm nổi bật lên tầm mắt ngay lập tức.
4. **Thẻ sản phẩm**: Viền mảnh `#e4e4e7`, khung ảnh nền trắng đồng nhất `aspect-ratio: 1/1`, hiệu ứng zoom ảnh mượt khi hover.
5. **Icon thống nhất**: 100% dùng `Bootstrap Icons` nét mảnh, loại bỏ emoji.
