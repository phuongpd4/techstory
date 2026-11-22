USE `techstore`;
SET NAMES utf8mb4;

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/nova-tab-ultra-12-02-lifestyle.jpg', 'lifestyle', 'Nova Tab Ultra 12 vẽ đồ họa cùng bút Nova Pen', 2
FROM products WHERE slug = 'may-tinh-bang-nova-tab-ultra-12';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/nova-tab-ultra-12-03-inthebox.jpg', 'inthebox', 'Phụ kiện trong hộp Nova Tab Ultra 12', 3
FROM products WHERE slug = 'may-tinh-bang-nova-tab-ultra-12';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/zenith-key-k75-02-detail.jpg', 'detail', 'Cận cảnh núm xoay âm lượng và khung nhôm CNC Zenith Key K75 Pro', 2
FROM products WHERE slug = 'ban-phim-co-zenith-key-k75-pro';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/zenith-key-k75-03-lifestyle.jpg', 'lifestyle', 'Góc làm việc cùng Zenith Key K75 Pro và Zenith Mouse M3', 3
FROM products WHERE slug = 'ban-phim-co-zenith-key-k75-pro';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/zenith-key-k75-03-lifestyle.jpg', 'lifestyle', 'Chuột Zenith Mouse M3 Ultra trên bàn làm việc', 2
FROM products WHERE slug = 'chuot-khong-day-zenith-mouse-m3-ultra';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/aurora-gan-100w-02-lifestyle.jpg', 'lifestyle', 'Củ sạc Aurora GaN 100W sạc cùng lúc Laptop và Điện thoại', 2
FROM products WHERE slug = 'cu-sac-nhanh-aurora-gan-100w';

INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
SELECT id, NULL, 'image', '/uploads/products/nova-powerbank-20k-02-lifestyle.jpg', 'lifestyle', 'Pin dự phòng Nova PowerBank 20.000mAh sạc nhanh Laptop 65W', 2
FROM products WHERE slug = 'pin-du-phong-nova-powerbank-20k-65w';
