<?php

function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
function money(int|float $n): string
{
    return number_format($n, 0, ',', '.') . 'đ';
}

// Sinh và lấy CSRF token lưu trong Session
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// In thẻ <input type="hidden"> chứa CSRF token để đặt trong các form POST
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Kiểm tra CSRF token khi người dùng gửi form POST lên
function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('403 - Phiên gửi biểu mẫu không hợp lệ (CSRF)');
    }
}

// Lấy thông tin người dùng đang đăng nhập (hoặc null nếu chưa đăng nhập)
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}