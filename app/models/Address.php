<?php
declare(strict_types=1);

class Address
{   
    // Truy vấn dữ liệu lấy danh sách địa chỉ của khách theo id
    public static function byUser(int $userId) : array {
        $stmt = Database::pdo()->prepare("SELECT * FROM addresses WHERE user_id = :u ORDER BY is_default DESC, id DESC");
        $stmt ->execute([':u' => $userId]);
        return $stmt->fetchAll();
    }
    // Lưu địa chỉ mới của khách vào bảng
    public static function create(int $userId, array $d) : void  {
        $sql = "INSERT INTO addresses (user_id, receiver, phone, province, district, ward, detail)
        VALUES (:u, :r, :ph, :pr, :di, :w, :de)";
        Database::pdo()->prepare($sql)->execute([
            ':u' => $userId,
            ':r' => $d['receiver'],
            ':ph' => $d['phone'],
            ':pr' => $d['province'],
            ':di' => $d['district'],
            ':w' => $d['ward'],
            ':de' => $d['detail'],
        ]);
    }
    // Xóa địa chỉ của khách hàng 
    public static function delete(int $id, int $userId) : void {
        Database::pdo()->prepare("DELETE FROM addresses WHERE id = :id AND user_id = :u")
        ->execute([
            ':id' => $id,
            ':u' => $userId,
            ]);
    }
}