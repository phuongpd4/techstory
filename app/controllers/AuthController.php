<?php

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->render('auth/login', ['title' => 'Đăng nhập']);
    }

    public function login(): void
    {
        verify_csrf();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->render('auth/login', [
                'title' => 'Đăng nhập',
                'error' => 'Email hoặc mật khẩu không chính xác.',
                'email' => $email,
            ]);
            return;
        }

        if ($user['status'] !== 'active') {
            $this->render('auth/login', [
                'title' => 'Đăng nhập',
                'error' => 'Tài khoản của bạn đã bị khóa.',
                'email' => $email,
            ]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => (int)$user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        $this->redirect('/');
    }

    public function showRegister(): void
    {
        $this->render('auth/register', ['title' => 'Đăng ký tài khoản']);
    }

    public function register(): void
    {
        verify_csrf();

        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || strlen($password) < 6) {
            $this->render('auth/register', [
                'title' => 'Đăng ký tài khoản',
                'error' => 'Vui lòng nhập đủ họ tên, email và mật khẩu từ 6 ký tự trở lên.',
                'old'   => $_POST,
            ]);
            return;
        }

        if (User::findByEmail($email)) {
            $this->render('auth/register', [
                'title' => 'Đăng ký tài khoản',
                'error' => 'Email này đã được sử dụng.',
                'old'   => $_POST,
            ]);
            return;
        }

        $userId = User::create($name, $email, $phone, $password);

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => $userId,
            'name'  => $name,
            'email' => $email,
            'role'  => 'customer',
        ];

        $this->redirect('/');
    }

    public function logout(): void
    {
        verify_csrf();
        unset($_SESSION['user']);
        session_regenerate_id(true);
        $this->redirect('/');
    }
}