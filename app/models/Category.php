<?php

class Category
{
    public static function all(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }
    
}