USE `techstore`;

-- 1. Danh mục sản phẩm
INSERT INTO categories (id, parent_id, name, slug) VALUES
  (1, NULL, 'Điện thoại',         'dien-thoai'),
  (2, NULL, 'Laptop',             'laptop'),
  (3, NULL, 'Tai nghe',           'tai-nghe'),
  (4, NULL, 'Đồng hồ thông minh', 'dong-ho-thong-minh');

-- 2. Thương hiệu
INSERT INTO brands (id, name, slug) VALUES
  (1, 'Nova',   'nova'),
  (2, 'Zenith', 'zenith'),
  (3, 'Aurora', 'aurora');

-- 3. Tài khoản mẫu (Mật khẩu chung: 123456)
INSERT INTO users (id, name, email, phone, password_hash, role) VALUES
  (1, 'Quản trị viên', 'admin@techstore.vn', '0901000111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
  (2, 'Nguyễn Văn A',  'khach@techstore.vn', '0902000222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');

-- 4. Sản phẩm gốc (6 sản phẩm)
INSERT INTO products (id, category_id, brand_id, name, slug, model_code, short_desc, description, design_desc, in_the_box, selling_points, warranty_months, is_featured) VALUES
  (1, 1, 1, 'Điện thoại Nova X Pro', 'dien-thoai-nova-x-pro', 'NVX-PRO-2026',
   'Flagship màn hình AMOLED 120Hz, chip Nova N3, cụm 3 camera 50MP chuyên nghiệp.',
   'Nova X Pro mang đến trải nghiệm đỉnh cao với khung viền Titan siêu bền, màn hình 6.7 inch tần số quét 120Hz mượt mà và viên pin 5000mAh hỗ trợ sạc siêu nhanh 67W.',
   'Mặt lưng kính nhám, khung titan, 3 camera sau xếp dọc',
   'Máy, Củ sạc 67W, Cáp USB-C, Ốp lưng trong, Que lấy sim, Sách HDSD',
   'Màn hình 120Hz mượt|Sạc nhanh 67W|Camera 50MP chống rung OIS',
   18, 1),

  (2, 1, 1, 'Điện thoại Nova Lite 5G', 'dien-thoai-nova-lite-5g', 'NVL-5G-2026',
   'Smartphone 5G mỏng nhẹ, màn hình OLED 90Hz, pin 5000mAh bền bỉ cả ngày.',
   'Thiết kế trẻ trung năng động, kết nối 5G tốc độ cao, phù hợp cho học sinh sinh viên và người dùng văn phòng.',
   'Mặt lưng polycarbonate nhám, khung phẳng, 2 camera sau',
   'Máy, Cáp USB-C, Que lấy sim, Sách HDSD',
   'Kết nối 5G siêu tốc|Thiết kế mỏng 7.8mm|Pin 5000mAh',
   12, 1),

  (3, 2, 2, 'Laptop ZenithBook Air 14', 'laptop-zenithbook-air-14', 'ZB-AIR14-2026',
   'Ultrabook vỏ nhôm nguyên khối siêu nhẹ 1.2kg, màn hình 2.8K OLED, pin 15 giờ.',
   'ZenithBook Air 14 là chiếc laptop lý tưởng cho công việc di động với vi xử lý thế hệ mới, màn hình chuẩn màu 100% DCI-P3.',
   'Vỏ nhôm nguyên khối CNC, viền màn hình siêu mỏng, bản lề mở 180 độ',
   'Laptop, Bộ sạc USB-C 65W, Túi chống sốc, Sách HDSD',
   'Siêu nhẹ 1.2kg|Màn hình 2.8K OLED|Pin 15 giờ làm việc',
   24, 1),

  (4, 2, 2, 'Laptop Zenith Gaming G16', 'laptop-zenith-gaming-g16', 'ZB-G16-2026',
   'Chiến binh gaming màn hình 16 inch 165Hz, tản nhiệt kép, bàn phím RGB.',
   'Hiệu năng vượt trội cho cả chơi game AAA lẫn dựng phim 4K, hệ thống tản nhiệt 2 quạt 5 ống đồng giữ máy luôn mát mẻ.',
   'Vỏ đen hầm hố, khe thoát nhiệt sau lưng, bàn phím LED RGB 4 vùng',
   'Laptop, Adapter 230W, Chuột gaming Zenith, Sách HDSD',
   'Màn hình 165Hz|Tản nhiệt 2 quạt 5 ống đồng|Bàn phím RGB',
   24, 1),

  (5, 3, 3, 'Tai nghe Aurora Buds Pro', 'tai-nghe-aurora-buds-pro', 'AU-BUDS-PRO',
   'Tai nghe True Wireless chống ồn chủ động ANC 45dB, âm thanh Hi-Res, pin 30 giờ.',
   'Aurora Buds Pro loại bỏ tiếng ồn xung quanh hiệu quả, mang lại không gian âm nhạc trong trẻo cùng thời lượng pin cả tuần.',
   'Hộp sạc dáng viên sỏi bo tròn, tai nghe in-ear có đuôi ngắn',
   'Tai nghe, Hộp sạc, 3 cặp đệm tai silicon, Cáp sạc USB-C',
   'Chống ồn ANC 45dB|Âm thanh Hi-Res|Pin 30 giờ kèm hộp sạc',
   12, 1),

  (6, 4, 1, 'Đồng hồ Nova Watch S2', 'dong-ho-nova-watch-s2', 'NV-WATCH-S2',
   'Đồng hồ thông minh mặt kính Sapphire, khung viền thép, định vị GPS độc lập.',
   'Theo dõi sức khỏe toàn diện 24/7: nhịp tim, SpO2, giấc ngủ và hơn 100 chế độ tập luyện thể thao.',
   'Mặt tròn cổ điển 46mm, khung thép không gỉ, 2 nút bấm vật lý bên phải',
   'Đồng hồ, Đế sạc nam châm, Dây đeo fluoroelastomer, Sách HDSD',
   'Kính Sapphire chống trầy|GPS độc lập|Pin 12 ngày',
   12, 1);

-- 5. Biến thể sản phẩm (10 biến thể khớp SKU, màu sắc, giá, tồn kho)
INSERT INTO product_variants (id, product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default) VALUES
  (1,  1, 'NVX-PRO-BLK-256', 'Đen than',   '#1C1C1E', '12GB', '256GB', 19990000, 18990000, 15, 1),
  (2,  1, 'NVX-PRO-BLU-512', 'Xanh dương', '#2F5D9E', '12GB', '512GB', 22990000, 21990000,  8, 0),
  (3,  2, 'NVL-5G-MNT-128',  'Xanh bạc hà','#3EB489', '8GB',  '128GB',  8990000,  7990000, 25, 1),
  (4,  2, 'NVL-5G-BLK-256',  'Đen nhám',   '#2C2C2E', '8GB',  '256GB',  9990000,  8990000, 12, 0),
  (5,  3, 'ZB-AIR14-SLV-512','Bạc ánh kim','#C0C0C7', '16GB', '512GB', 26990000, 24990000, 10, 1),
  (6,  3, 'ZB-AIR14-GRY-1TB','Xám không gian','#4A4A4F','16GB','1TB',   29990000, 27990000,  5, 0),
  (7,  4, 'ZB-G16-BLK-1TB',  'Đen thiên thạch','#18181B','32GB','1TB',  36990000, 34990000,  6, 1),
  (8,  5, 'AU-BUDS-WHT',     'Trắng ngọc', '#F5F5F7', NULL,   NULL,     3490000,  2990000, 40, 1),
  (9,  5, 'AU-BUDS-BLK',     'Đen bóng',   '#1D1D1F', NULL,   NULL,     3490000,  2990000, 30, 0),
  (10, 6, 'NV-WATCH-S2-BLK', 'Đen viền thép','#222225',NULL,  '32GB',   4990000,  4490000, 20, 1);

-- 6. Thông số kỹ thuật
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order) VALUES
  (1, 'Màn hình & Hiển thị', 'Kích thước màn hình', '6.7 inch AMOLED 120Hz', 1),
  (1, 'Cấu hình & Hiệu năng', 'Vi xử lý (Chip)',     'Nova N3 8 nhân (4nm)',  2),
  (1, 'Cấu hình & Hiệu năng', 'RAM',                 '12GB LPDDR5X',          3),
  (1, 'Camera',               'Camera sau',          '50MP (OIS) + 12MP + 12MP', 4),
  (1, 'Pin & Sạc',            'Dung lượng pin',      '5000 mAh, sạc nhanh 67W',  5),

  (2, 'Màn hình & Hiển thị', 'Kích thước màn hình', '6.5 inch OLED 90Hz',    1),
  (2, 'Cấu hình & Hiệu năng', 'Vi xử lý (Chip)',     'Nova N1 5G',            2),
  (2, 'Pin & Sạc',            'Dung lượng pin',      '5000 mAh, sạc 33W',     3),

  (3, 'Màn hình & Hiển thị', 'Màn hình',            '14 inch 2.8K (2880x1800) OLED 90Hz', 1),
  (3, 'Cấu hình & Hiệu năng', 'CPU',                 'Zenith Core Ultra 7',   2),
  (3, 'Cấu hình & Hiệu năng', 'Trọng lượng',         '1.2 kg',                3),
  (3, 'Pin & Sạc',            'Thời lượng pin',      'Lên đến 15 giờ (65W USB-C)', 4),

  (4, 'Màn hình & Hiển thị', 'Màn hình',            '16 inch QHD+ 165Hz IPS', 1),
  (4, 'Cấu hình & Hiệu năng', 'Card đồ họa',         'RTX 4060 8GB GDDR6',     2),
  (4, 'Cấu hình & Hiệu năng', 'RAM',                 '32GB DDR5 5600MHz',      3),

  (5, 'Âm thanh & Kết nối',   'Chống ồn',            'ANC chủ động 45dB + Xuyên âm', 1),
  (5, 'Âm thanh & Kết nối',   'Kết nối',             'Bluetooth 5.4, Codec LDAC',    2),
  (5, 'Pin & Sạc',            'Thời lượng pin',      '7 giờ (tai nghe) / 30 giờ (kèm hộp)', 3),

  (6, 'Màn hình & Thiết kế',  'Mặt kính',            'Sapphire 1.43 inch AMOLED', 1),
  (6, 'Tính năng',            'Định vị & Chống nước','GPS băng tần kép, 5ATM',    2),
  (6, 'Pin & Sạc',            'Thời lượng pin',      '12 ngày sử dụng tiêu chuẩn', 3);

-- 7. Hình ảnh sản phẩm (Khớp từng biến thể màu)
INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order) VALUES
  (1, 1, 'image', 'https://placehold.co/600x600/1C1C1E/FFFFFF?text=Nova+X+Pro+(Den+256GB)',  'front', 'Điện thoại Nova X Pro màu Đen than',   1),
  (1, 2, 'image', 'https://placehold.co/600x600/2F5D9E/FFFFFF?text=Nova+X+Pro+(Xanh+512GB)', 'front', 'Điện thoại Nova X Pro màu Xanh dương', 2),
  (2, 3, 'image', 'https://placehold.co/600x600/3EB489/FFFFFF?text=Nova+Lite+5G+(Xanh+Mint)','front', 'Điện thoại Nova Lite 5G màu Xanh bạc hà', 1),
  (2, 4, 'image', 'https://placehold.co/600x600/2C2C2E/FFFFFF?text=Nova+Lite+5G+(Den+Nham)', 'front', 'Điện thoại Nova Lite 5G màu Đen nhám',   2),
  (3, 5, 'image', 'https://placehold.co/600x600/C0C0C7/111111?text=ZenithBook+Air+14+(Bac)', 'front', 'Laptop ZenithBook Air 14 màu Bạc',       1),
  (3, 6, 'image', 'https://placehold.co/600x600/4A4A4F/FFFFFF?text=ZenithBook+Air+14+(Xam)', 'front', 'Laptop ZenithBook Air 14 màu Xám',       2),
  (4, 7, 'image', 'https://placehold.co/600x600/18181B/22C55E?text=Zenith+Gaming+G16',       'front', 'Laptop Zenith Gaming G16',               1),
  (5, 8, 'image', 'https://placehold.co/600x600/F5F5F7/111111?text=Aurora+Buds+Pro+(Trang)', 'front', 'Tai nghe Aurora Buds Pro màu Trắng',     1),
  (5, 9, 'image', 'https://placehold.co/600x600/1D1D1F/FFFFFF?text=Aurora+Buds+Pro+(Den)',   'front', 'Tai nghe Aurora Buds Pro màu Đen',       2),
  (6, 10,'image', 'https://placehold.co/600x600/222225/38BDF8?text=Nova+Watch+S2',           'front', 'Đồng hồ thông minh Nova Watch S2',       1);

-- 8. Mã giảm giá mẫu
INSERT INTO coupons (code, type, value, min_order, usage_limit, status) VALUES
  ('TECH50K',  'fixed',   50000,   1000000, 100, 'active'),
  ('WELCOME10','percent', 10,      5000000, 50,  'active');