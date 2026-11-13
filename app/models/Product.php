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
    // Giỏ hàng, đặt hàng - Lấy thông tin chi tiết các biến thể 
    public static function findVariantsByIds(array $variantIds): array
    {
        if (empty($variantIds)) {
            return [];
        }
        // Tạo chuỗi '?,?,?' tương ứng với số lượng ID cần tìm
        $placeholders = implode(',', array_fill(0, count($variantIds), '?'));
        $sql = "
            SELECT v.id AS variant_id, v.product_id, v.sku, v.color, v.ram, v.storage,
                   v.price, v.sale_price, v.stock,
                   p.name AS product_name, p.slug AS product_slug,
                   (SELECT m.file_path FROM product_media m
                    WHERE m.product_id = p.id
                      AND (m.variant_id = v.id OR m.variant_id IS NULL)
                    ORDER BY (m.variant_id = v.id) DESC, m.sort_order ASC
                    LIMIT 1) AS image
            FROM product_variants v
            JOIN products p ON p.id = v.product_id
            WHERE v.id IN ({$placeholders})
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute(array_values($variantIds));
        return $stmt->fetchAll();
    }
    
    // Lấy danh sách sản phẩm cho trang admin
    public static function adminALL(): array
    {
         $sql = "
            SELECT p.id, p.name, p.slug, p.model_code, p.status, p.is_featured,
                   c.name AS category_name, b.name AS brand_name,
                   v.sku, v.color, v.price, v.sale_price, v.stock,
                   m.file_path AS image
            FROM products p
            JOIN categories c ON c.id = p.category_id
            JOIN brands b ON b.id = p.brand_id
            LEFT JOIN product_variants v ON v.product_id = p.id AND v.is_default = 1
            LEFT JOIN product_media m ON m.product_id = p.id AND m.sort_order = 1
            ORDER BY p.id DESC
        ";
        return Database::pdo()->query($sql)->fetchAll();
    }

    // Thêm mới sản phẩm + biến thể mặc định + ảnh đại diện(transaction)
    public static function createWithDefaultVariant(array $data) : int
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();    

        try{
            $slug = slugify($data['name']);
            // Thêm vào bảng products
            $stmtProd = $pdo->prepare("
                INSERT INTO products (
                    category_id, brand_id, name, slug, model_code, short_desc, description,
                     selling_points, warranty_months, is_featured, status
                ) VALUES (
                     :category_id,
                     :brand_id,
                     :name,
                     :slug,
                     :model_code,
                     :short_desc,
                     :description,
                     :selling_points,
                     :warranty_months,
                     1,
                     'published'
                )
            ");
            $stmtProd->execute([
                ':category_id' => (int)$data['category_id'],
                ':brand_id' => (int)$data['brand_id'],
                ':name' => $data['name'],
                ':slug' => $slug,
                ':model_code' => $data['model_code'],
                ':short_desc' => $data['short_desc'],
                ':description' => $data['description'],
                ':selling_points' => $data['selling_points'],
                ':warranty_months' => (int)$data['warranty_months']
            ]);

            $productId = (int)$pdo->lastInsertId();
            //Thêm biến thể mặc định vào product_variants
            $stmtVar = $pdo->prepare("
                INSERT INTO product_variants
                (
                    product_id,
                    sku,
                    color,
                    color_hex,
                    ram,
                    storage,
                    price,
                    sale_price,
                    stock,
                    is_default
                ) VALUES 
                (
                    :product_id,
                    :sku,
                    :color,
                    :color_hex,
                    :ram,
                    :storage,
                    :price,
                    :sale_price,
                    :stock,
                    1
                ) 
            ");
            $stmtVar->execute([
                ':product_id' => $productId,
                ':sku' => strtoupper($data['sku']),
                ':color' => $data['color'],
                ':color_hex' => $data['color_hex'] ?: '#1C1C1E',
                ':ram' => $data['ram'] ?: null,
                ':storage' => $data['storage'] ?: null,
                ':price' => (int)$data['price'],
                ':sale_price' => !empty($data['sale_price']) ? (int)$data['sale_price'] : null,
                ':stock' => (int)$data['stock'],
            ]);

            $variantID = (int)$pdo->lastInsertId();
            // Thêm ảnh đại diện sản phẩm vào product_media
            $imageUrl = $data['image_url'] ?: 'https://placehold.co/600x600/1C1C1E/FFFFFF?text=' . urlencode($data['name']);
            $stmtMedia = $pdo->prepare("
                        INSERT INTO product_media
                        (
                            product_id,
                            variant_id,
                            type,
                            file_path,
                            angle,
                            alt_text,
                            sort_order
                        ) VALUES (
                            :product_id,
                            :variant_id,
                            'image',
                            :file_path,
                            'front',
                            :alt_text,
                            1 
                        )
            ");
            $stmtMedia->execute([
                ':product_id' => $productId,
                ':variant_id' => $variantID,
                ':file_path' => $imageUrl,
                ':alt_text' =>$data['name'] . ' ' . $data['color'],

            ]);
            $pdo->commit();
            return $productId;
        } catch (Throwable $e)
            {
                $pdo->rollBack();
                throw $e;
            }
    }
    // Tìm sản phẩm theo ID
    public static function findByID(int $id) : ?array {
        $stmt = Database::pdo()->prepare('SELECT * FROM products WHERE  id = :id LIMIT 1');
        $stmt ->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public static function addVariant(int $productId, array $data): int{
        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try{
            $stmtVar = $pdo->prepare("
            INSERT INTO product_variants(
            product_id, sku, color, color_hex, ram, storage, price, sale_price, stock, is_default) VALUES (
            :product_id, :sku, :color, :color_hex, :ram, :storage, :price, :sale_price, :stock, 0)
            ");
            $stmtVar->execute([
                ':product_id' => $productId,
                ':sku'        => $data['sku'],
                ':color'      => $data['color'],
                ':color_hex'  => $data['color_hex'],
                ':ram'        => $data['ram'] ?: null,
                ':storage'    => $data['storage'] ?: null,
                ':price'      => (int)$data['price'],
                ':sale_price' => !empty($data['sale_price']) ? (int)$data['sale_price'] : null,
                ':stock'      => (int)$data['stock'],
            ]);
            $variantId = (int)$pdo->lastInsertId();
            $stmtMedia = $pdo->prepare("
                INSERT INTO product_media (product_id, variant_id, type, file_path, angle, alt_text, sort_order)
                VALUES (:product_id, :variant_id, 'image', :file_path, 'front', :alt_text, 2)
            ");
            $stmtMedia->execute([
                ':product_id' => $productId,
                ':variant_id' => $variantId,
                ':file_path'  => $data['image_path'],
                ':alt_text'   => $data['product_name'] . ' ' . $data['color'],
            ]);
            $pdo->commit();
            return $variantId;
        }catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}