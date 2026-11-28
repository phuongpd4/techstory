<?php

class Category
{
    public static function all(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }
    // Sắp xếp danh mục theo mức độ phổ biến ở trang chủ

    public static function popular() : array {
        $sql = "
                SELECT c.*,
                    COUNT(DISTINCT p.id) AS product_count,
                    COALESCE(SUM(CASE WHEN o.id IS NOT NULL THEN oi.quantity ELSE 0 END),0) AS total_sold
                FROM categories c
                LEFT JOIN products p ON p.category_id = c.id AND p.status = 'published'
                LEFT JOIN product_variants pv ON pv.product_id = p.id
                LEFT JOIN order_items oi ON oi.variant_id = pv.id
                LEFT JOIN orders o ON o.id = oi.order_id AND o.status != 'cancelled'
                GROUP BY c.id
                ORDER BY
                    total_sold DESC,
                    CASE c.slug
                        WHEN 'dien-thoai'           THEN 1
                        WHEN 'laptop'               THEN 2
                        WHEN 'may-tinh-bang'        THEN 3
                        WHEN 'tai-nghe'             THEN 4
                        WHEN 'dong-ho-thong-minh'   THEN 5
                        WHEN 'ban-phim-chuot'       THEN 6
                        WHEN 'phu-kien-sac-cap'     THEN 7 
                        ELSE 99
                    END ASC,
                    product_count DESC,
                    c.id ASC
                     ";
            return Database::pdo()->query($sql)->fetchAll();         
    }                   
    
}