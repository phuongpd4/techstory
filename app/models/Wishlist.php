<?php
declare(strict_types=1);
class Wishlist
{
    // Truy vấn lấy danh sách các sản phẩm mà id user thả tim kèm giá thấp nhất và ảnh đại diện
    public static function byUser(int $userId): array
    {
          $sql = "SELECT p.id, p.name, p.slug, b.name AS brand_name,
                       MIN(COALESCE(v.sale_price, v.price)) AS min_price,
                       (SELECT file_path FROM product_media pm WHERE pm.product_id = p.id ORDER BY sort_order ASC LIMIT 1) AS image
                FROM wishlists w
                JOIN products p ON p.id = w.product_id
                JOIN brands b ON b.id = p.brand_id
                LEFT JOIN product_variants v ON v.product_id = p.id
                WHERE w.user_id = :uid
                GROUP BY p.id, p.name, p.slug, b.name
                ORDER BY MAX(w.created_at) DESC";
         $stmt = Database::pdo()->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }
    // Nhận id người dùng và id sản phẩm -> hiện nút bỏ yêu thích hay yêu thích
    public static function exists(int $userId, int $productId): bool
    {
        $stmt = Database::pdo()->prepare("SELECT 1 FROM wishlists WHERE user_id = :u AND product_id = :p");
        $stmt->execute(['u' => $userId, 'p' => $productId]);
        return (bool)$stmt->fetchColumn();
    }
    // Thêm hoặc xóa sản phẩm khỏi danh sách

    public static function toggle(int $userId, $productId) : void
    {
        if(self::exists($userId, $productId)){
            $stmt = Database::pdo()->prepare("DELETE FROM wishlists WHERE user_id = :u AND  product_id = :p");            
        }else{
            $stmt = Database::pdo()->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (:u,:p)");            
        }   
        $stmt->execute(['u' => $userId, 'p' => $productId]);
    }
}