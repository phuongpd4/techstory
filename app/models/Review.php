<?php
class Review{
    // Trả về đánh giá và id sản phẩm đang xem
    public static function byProduct(int $productId) : array 
    {
    
        $sql = "SELECT r.*, u.name AS user_name FROM reviews r
         JOIN users u ON u.id = r.user_id
         WHERE r.product_id = :pid AND r.status = 'approved'
            ORDER BY r.id DESC";
            $stmt = Database::pdo()->prepare($sql);
             $stmt ->execute([':pid' => $productId]);
         return $stmt->fetchAll();
    }
    //Lưu đánh giá
    public static function create(int $productId, int $userId, int $rating, string $content) : void
    {
        $sql = " INSERT INTO reviews (product_id, user_id, rating, content, status)
        VALUE (:pid, :uid, :rating, :content, 'approved')";
        $stmt= Database::pdo()->prepare($sql);
        $stmt->execute([
            ':pid' => $productId,
            ':uid' => $userId,
            ':rating' => max(1,min(5,$rating)),
            ':content' => $content,

        ]);
        
    }
}