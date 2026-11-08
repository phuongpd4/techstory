<?php

class Brand
{
    public static function all(): array
    {
        $stmt = Database::pdo()->query('SELECT * FROM brands ORDER BY name');
        return $stmt->fetchAll();
    }
    
}