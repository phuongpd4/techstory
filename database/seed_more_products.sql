USE `techstore`;

-- Thêm 3 danh mục mới
INSERT IGNORE INTO categories (id, parent_id, name, slug) VALUES
  (5, NULL, 'Máy tính bảng',    'may-tinh-bang'),
  (6, NULL, 'Bàn phím & Chuột', 'ban-phim-chuot'),
  (7, NULL, 'Phụ kiện sạc cáp', 'phu-kien-sac-cap');

-- Thêm 6 sản phẩm mới đa dạng (dùng AUTO_INCREMENT để không trùng ID với sản phẩm người dùng tự thêm)
INSERT IGNORE INTO products (category_id, brand_id, name, slug, model_code, short_desc, description, in_the_box, selling_points, warranty_months, is_featured, status) VALUES
  (5, 1, 'Máy tính bảng Nova Tab Ultra 12', 'may-tinh-bang-nova-tab-ultra-12', 'NV-TAB-U12',
   'Màn hình 12.4 inch OLED 120Hz siêu mỏng kèm bút cảm ứng từ tính độ trễ cực thấp.',
   'Nova Tab Ultra 12 mang đến không gian làm việc và sáng tạo đồ họa chuyên nghiệp với vỏ nhôm nguyên khối mỏng 5.5mm và 4 loa Dolby Atmos.',
   'Máy tính bảng, Bút cảm ứng Nova Pen, Củ sạc 45W, Cáp USB-C',
   'Màn hình 12.4 inch OLED 120Hz|Tặng kèm bút Nova Pen|Pin 10.000mAh sạc 45W', 18, 1, 'published'),

  (5, 3, 'Máy tính bảng Aurora Pad Air 11', 'may-tinh-bang-aurora-pad-air-11', 'AU-PAD-A11',
   'Tablet 11 inch mỏng nhẹ, màu xanh pastel trẻ trung, lý tưởng cho học tập và giải trí.',
   'Aurora Pad Air 11 sở hữu màn hình 2K sắc nét, trọng lượng chỉ 460g giúp dễ dàng mang theo mọi nơi.',
   'Máy tính bảng, Cáp USB-C, Sách HDSD',
   'Siêu nhẹ 460g|Màn hình 11 inch 2K|4 loa vòm sống động', 12, 1, 'published'),

  (6, 2, 'Bàn phím cơ Zenith Key K75 Pro', 'ban-phim-co-zenith-key-k75-pro', 'ZN-KEY-K75',
   'Bàn phím cơ không dây 3 chế độ, vỏ nhôm CNC, núm xoay âm lượng, switch Linear êm ái.',
   'Zenith Key K75 Pro trang bị mạch Hotswap 5 pin, gasket mount gõ cực đầm tay cùng pin 4000mAh dùng nhiều tuần.',
   'Bàn phím, Receiver 2.4GHz, Cáp USB-C bọc dù, Keycap puller',
   'Vỏ nhôm CNC nguyên khối|3 chế độ kết nối (BT/2.4G/Dây)|Hotswap 5 pin & Gasket Mount', 12, 1, 'published'),

  (6, 2, 'Chuột không dây Zenith Mouse M3 Ultra', 'chuot-khong-day-zenith-mouse-m3-ultra', 'ZN-MS-M3U',
   'Chuột công thái học không dây siêu nhẹ 49g, cảm biến 26.000 DPI chính xác tuyệt đối.',
   'Thiết kế ôm tay chống mỏi cổ tay khi làm việc và chơi game cường độ cao, pin lên đến 90 giờ.',
   'Chuột không dây, Receiver 2.4GHz, Cáp sạc siêu mềm, Bộ feet dự phòng',
   'Siêu nhẹ chỉ 49g|Cảm biến 26.000 DPI|Pin 90 giờ sử dụng', 12, 0, 'published'),

  (7, 3, 'Củ sạc nhanh Aurora GaN 100W 4 cổng', 'cu-sac-nhanh-aurora-gan-100w', 'AU-GAN-100W',
   'Công nghệ GaN siêu nhỏ gọn, 3 cổng USB-C + 1 cổng USB-A, sạc cùng lúc cả Laptop và Điện thoại.',
   'Tích hợp chip kiểm soát nhiệt độ thông minh, chân cắm gập gọn tiện lợi khi đi công tác, du lịch.',
   'Củ sạc GaN 100W, Sách HDSD',
   'Công suất cực đại 100W|Sạc cùng lúc 4 thiết bị|Chân cắm gập gọn chống quá nhiệt', 24, 0, 'published'),

  (7, 1, 'Pin sạc dự phòng Nova PowerBank 20.000mAh 65W', 'pin-du-phong-nova-powerbank-20k-65w', 'NV-PB-20K65',
   'Dung lượng khủng 20.000mAh, sạc nhanh PD 65W cho cả Laptop, màn hình LED báo phần trăm pin.',
   'Vỏ nhôm anodized tản nhiệt tốt, an toàn mang lên máy bay, hỗ trợ sạc nhanh 2 chiều siêu tốc.',
   'Pin dự phòng 20.000mAh, Cáp USB-C 100W, Túi vải bảo vệ',
   'Sạc nhanh 65W cho cả Laptop|Màn hình LED báo % pin|An toàn mang lên máy bay', 12, 1, 'published');

-- Biến thể mặc định cho 6 sản phẩm mới
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'NV-TAB-U12-GRY-256', 'Xám không gian', '#4A4A4F', '12GB', '256GB', 18990000, 17490000, 14, 1 FROM products WHERE slug = 'may-tinh-bang-nova-tab-ultra-12';
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'AU-PAD-A11-BLU-128', 'Xanh da trời', '#7DD3FC', '8GB', '128GB', 9490000, 8490000, 20, 1 FROM products WHERE slug = 'may-tinh-bang-aurora-pad-air-11';
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'ZN-KEY-K75-GRY', 'Xám đen CNC', '#27272A', NULL, 'Linear Switch', 2490000, 2190000, 25, 1 FROM products WHERE slug = 'ban-phim-co-zenith-key-k75-pro';
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'ZN-MS-M3U-WHT', 'Trắng nhám', '#F8FAFC', NULL, '49g Wireless', 1490000, 1290000, 30, 1 FROM products WHERE slug = 'chuot-khong-day-zenith-mouse-m3-ultra';
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'AU-GAN-100W-GRY', 'Xám Titan', '#52525B', NULL, '100W 4 cổng', 990000, 790000, 50, 1 FROM products WHERE slug = 'cu-sac-nhanh-aurora-gan-100w';
INSERT IGNORE INTO product_variants (product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default)
SELECT id, 'NV-PB-20K65-BLK', 'Đen Anodized', '#18181B', NULL, '20.000mAh 65W', 1390000, 1190000, 35, 1 FROM products WHERE slug = 'pin-du-phong-nova-powerbank-20k-65w';

-- Ảnh đại diện Studio AI cho 6 sản phẩm mới
INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/nova-tab-ultra-12.jpg', 'front', 'Máy tính bảng Nova Tab Ultra 12', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'may-tinh-bang-nova-tab-ultra-12' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/aurora-pad-air-11.jpg', 'front', 'Máy tính bảng Aurora Pad Air 11', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'may-tinh-bang-aurora-pad-air-11' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/zenith-key-k75.jpg', 'front', 'Bàn phím cơ Zenith Key K75 Pro', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'ban-phim-co-zenith-key-k75-pro' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/zenith-mouse-m3.jpg', 'front', 'Chuột không dây Zenith Mouse M3 Ultra', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'chuot-khong-day-zenith-mouse-m3-ultra' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/aurora-gan-100w.jpg', 'front', 'Củ sạc nhanh Aurora GaN 100W', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'cu-sac-nhanh-aurora-gan-100w' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT p.id, v.id, 'image', '/uploads/products/nova-powerbank-20k.jpg', 'front', 'Pin dự phòng Nova PowerBank 20.000mAh 65W', 1
FROM products p JOIN product_variants v ON v.product_id = p.id WHERE p.slug = 'pin-du-phong-nova-powerbank-20k-65w' AND NOT EXISTS (SELECT 1 FROM product_media pm WHERE pm.product_id = p.id);

-- Thông số kỹ thuật cơ bản cho 6 sản phẩm mới
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Màn hình', 'Màn hình', '12.4 inch OLED 120Hz 2.8K', 1 FROM products WHERE slug = 'may-tinh-bang-nova-tab-ultra-12' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Pin', 'Dung lượng pin', '10.000 mAh, sạc nhanh 45W', 2 FROM products WHERE slug = 'may-tinh-bang-nova-tab-ultra-12' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;

INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Màn hình', 'Màn hình', '11 inch IPS 2K 90Hz', 1 FROM products WHERE slug = 'may-tinh-bang-aurora-pad-air-11' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thiết kế', 'Trọng lượng', '460 gram', 2 FROM products WHERE slug = 'may-tinh-bang-aurora-pad-air-11' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;

INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Cấu hình', 'Kết nối', '3 Mode (Bluetooth 5.3 / 2.4GHz / USB-C)', 1 FROM products WHERE slug = 'ban-phim-co-zenith-key-k75-pro' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thiết kế', 'Vỏ & Pin', 'Nhôm CNC, Pin 4000mAh', 2 FROM products WHERE slug = 'ban-phim-co-zenith-key-k75-pro' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;

INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Cấu hình', 'Cảm biến', 'PAW3395 26.000 DPI', 1 FROM products WHERE slug = 'chuot-khong-day-zenith-mouse-m3-ultra' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thiết kế', 'Trọng lượng', '49 gram siêu nhẹ', 2 FROM products WHERE slug = 'chuot-khong-day-zenith-mouse-m3-ultra' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;

INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thông số', 'Công suất', '100W Max (GaN thế hệ 3)', 1 FROM products WHERE slug = 'cu-sac-nhanh-aurora-gan-100w' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thông số', 'Cổng kết nối', '3 cổng USB-C + 1 cổng USB-A', 2 FROM products WHERE slug = 'cu-sac-nhanh-aurora-gan-100w' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;

INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thông số', 'Dung lượng', '20.000 mAh (74Wh)', 1 FROM products WHERE slug = 'pin-du-phong-nova-powerbank-20k-65w' AND NOT EXISTS (SELECT 1 FROM product_specs ps WHERE ps.product_id = products.id);
INSERT INTO product_specs (product_id, group_name, spec_key, spec_value, sort_order)
SELECT id, 'Thông số', 'Công suất sạc', 'PD 65W 2 chiều', 2 FROM products WHERE slug = 'pin-du-phong-nova-powerbank-20k-65w' AND (SELECT COUNT(*) FROM product_specs ps WHERE ps.product_id = products.id) < 2;
