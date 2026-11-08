<?php

class Product
{

    public static function filter(array $filters = []): array
    {
        $where  = ["p.status = 'published'"];
        $params = [];
        // 1. Lọc theo slug danh mục
        if (!empty($filters['category'])) {
            $where[] = 'c.slug = :category';
            $params[':category'] = $filters['category'];
        }
        // 2. Lọc theo slug thương hiệu
        if (!empty($filters['brand'])) {
            $where[] = 'b.slug = :brand';
            $params[':brand'] = $filters['brand'];
        }
        // 3. Tìm kiếm theo tên sản phẩm
        if (!empty($filters['q'])) {
            $where[] = 'p.name LIKE :q';
            $params[':q'] = '%' . $filters['q'] . '%';
        }
        // 4. Lọc theo khoảng giá (dựa trên giá thực bán COALESCE(v.sale_price, v.price))
        if (!empty($filters['min_price'])) {
            $where[] = 'COALESCE(v.sale_price, v.price) >= :min_price';
            $params[':min_price'] = (int)$filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'COALESCE(v.sale_price, v.price) <= :max_price';
            $params[':max_price'] = (int)$filters['max_price'];
        }
        // 5. Sắp xếp
        $orderBy = match ($filters['sort'] ?? '') {
            'price_asc'  => 'COALESCE(v.sale_price, v.price) ASC',
            'price_desc' => 'COALESCE(v.sale_price, v.price) DESC',
            'name_asc'   => 'p.name ASC',
            default      => 'p.id DESC',
        };
        $whereSql = implode(' AND ', $where);
        $sql = "
            SELECT p.id, p.name, p.slug, p.short_desc,
                   c.name AS category_name, b.name AS brand_name,
                   v.sku, v.price, v.sale_price, v.stock,
                   m.file_path AS image
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN brands b ON b.id = p.brand_id
            JOIN product_variants v ON v.product_id = p.id AND v.is_default = 1
            LEFT JOIN product_media m ON m.product_id = p.id AND m.sort_order = 1
            WHERE {$whereSql}
            ORDER BY {$orderBy}
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function featured(int $limit = 6): array
    {
        $sql = " SELECT p.id, p.name, p.slug, p.short_desc,
         c.name AS category_name, b.name AS brand_name, v.sku, v.price, v.sale_price, v.stock,
         m.file_path AS image
                 FROM products p
                 JOIN categories c ON c.id = p.category_id
                 JOIN brands b ON b.id = p.brand_id
                 JOIN product_variants v ON v.product_id = p.id and v.is_default = 1
                 LEFT JOIN product_media m ON m.product_id = p.id AND m.sort_order = 1
                 WHERE p.status = 'published' AND p.is_featured = 1
                 ORDER BY p.id DESC
                 LIMIT :limit";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    //Tìm kiếm sản phẩm theo slug, trả về mảng dữ liệu sản phẩm hoặc null nếu không tìm thấy
    public static function findBySlug(string $slug): ?array
    {
        $sql = "
            SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                   b.name AS brand_name, b.slug AS brand_slug
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN brands b ON b.id = p.brand_id
            WHERE p.slug = :slug AND p.status = 'published'
            LIMIT 1
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    //Lấy biến thể màu/ dung lượng kèm ảnh tương ứng
     public static function variants(int $productId): array
    {
        $sql = "
            SELECT v.*,
                   (SELECT m.file_path FROM product_media m
                    WHERE m.product_id = v.product_id
                      AND (m.variant_id = v.id OR m.variant_id IS NULL)
                    ORDER BY (m.variant_id = v.id) DESC, m.sort_order ASC
                    LIMIT 1) AS image
            FROM product_variants v
            WHERE v.product_id = :pid
            ORDER BY v.is_default DESC, v.id ASC
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll();
    }
    // Lấy bảng thông số kỹ thuật
    public static function specs(int $productId): array
    {
        $stmt = Database::pdo()->prepare(
            'SELECT * FROM product_specs WHERE product_id = :pid ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll();
    }
}