<?php

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if(current_user()){
            $this->redirect('/');
            return;
        }
        $this->render('auth/login', ['title' => 'Đăng nhập']);
    }

    public function login(): void
    {
        verify_csrf();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if($email === '' || $password === ''){
            $this->render('auth/login',[
                'title' => 'Đăng nhập',
                'error' => 'Vui lòng nhập đầy đủ email và mật khẩu',
                'email' => $email,
            ]);
            return;
        }


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
        if($user['role'] === 'admin'){
            unset($_SESSION['cart'], $_SESSION['coupon_code']);
        }
        set_flash('success', 'Chào mừng ' . $user['name'] . ' quay trở lại PhuongStore');
        $this->redirect('/');
    }

    public function showRegister(): void
    {   
        if(current_user()){
            $this->redirect('/');
            return;
        }
        $this->render('auth/register', ['title' => 'Đăng ký tài khoản']);
    }

    public function register(): void
    {
        verify_csrf();

        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $old = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ];
        $error = null;

        if($name === '' || $email === ''){
            $error = 'Vui lòng nhập đầy đủ họ tên và email';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = 'Địa chỉ email không đúng định dạng';
        }elseif($phone !== '' && !preg_match('/^0[0-9]{9,10}$/', $phone)){
            $error = 'Số điện thoại không hợp lệ (gồm 10-11 chữ số, bắt đầu bằng số 0)';
        }elseif(strlen($password) <6){
            $error = 'Mật khẩu phải có từ 6 ký tự trở lên';
        }elseif($password !== $passwordConfirm){
            $error = 'Mật khẩu nhập lại không khớp. Vui lòng kiểm tra lại.';
        }elseif(User::findByEmail($email)){
            $error = 'Email này đã được sử dụng. Hãy sử dụng email khác.';
        }
        if($error !== null){
            $this->render('auth/register',[
                'title' => 'Đăng ký tài khoản',
                'error' => $error,
                'old' => $old,       
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
        set_flash('success', 'Đăng ký tài khoản thành công! Chào mừng ' . $name . ' đến với TechStore.');
        $this->redirect('/');
    }

    public function logout(): void
    {
        verify_csrf();
        unset($_SESSION['user'], $_SESSION['cart'], $_SESSION['coupon_code']);
        session_regenerate_id(true);
        set_flash('info', 'Bạn đã đăng xuất khỏi tài khoản.');
        $this->redirect('/');
    }
}