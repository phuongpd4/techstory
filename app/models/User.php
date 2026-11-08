<?php

class User
{
    // Tìm người dùng theo email
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Tạo tài khoản khách hàng mới
    public static function create(string $name, string $email, string $phone, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = Database::pdo()->prepare("
            INSERT INTO users (name, email, phone, password_hash, role, status)
            VALUES (:name, :email, :phone, :hash, 'customer', 'active')
        ");

        $stmt->execute([
            ':name'  => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':hash'  => $hash,
        ]);

        return (int)Database::pdo()->lastInsertId();
    }
}