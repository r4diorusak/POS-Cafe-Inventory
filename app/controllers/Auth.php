<?php
/**
 * Auth Controller
 * Menangani autentikasi dan login/logout
 */
class AuthController extends Controller {
    
    public function index() {
        $this->view('auth/login');
    }
    
    /**
     * Login action
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = antiinjection($_POST['username'] ?? '');
            $password = antiinjection($_POST['password'] ?? '');
            
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password harus diisi';
                $this->redirect('../index.php?controller=auth&action=index');
            }
            
            $userModel = $this->model('User');
            $user = $userModel->findByCredentials($username, $password);
            
            if ($user) {
                session_start();
                $_SESSION['namauser'] = $user['username'];
                $_SESSION['passuser'] = $user['password'];
                $_SESSION['leveluser'] = $user['level'];
                $_SESSION['userId'] = $user['id'];
                
                $this->redirect('../media.php?module=home');
            } else {
                // Coba di tabel users
                $userKasirModel = $this->model('UserKasir');
                $userKasir = $userKasirModel->findByCredentials($username, $password);
                
                if ($userKasir) {
                    session_start();
                    $_SESSION['namauser'] = $userKasir['username'];
                    $_SESSION['passuser'] = $userKasir['password'];
                    $_SESSION['leveluser'] = $userKasir['level'];
                    $_SESSION['userId'] = $userKasir['id'];
                    
                    $this->redirect('../media.php?module=home');
                } else {
                    $_SESSION['error'] = 'Username atau password salah';
                    $this->redirect('../index.php?controller=auth&action=index');
                }
            }
        } else {
            $this->view('auth/login');
        }
    }
    
    /**
     * Logout action
     */
    public function logout() {
        session_start();
        session_destroy();
        $this->redirect('../index.php');
    }
    
    /**
     * Register action
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = antiinjection($_POST['username'] ?? '');
            $password = antiinjection($_POST['password'] ?? '');
            $confirmPassword = antiinjection($_POST['confirm_password'] ?? '');
            
            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = 'Semua field harus diisi';
                $this->redirect('../index.php?controller=auth&action=register');
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Password tidak sama';
                $this->redirect('../index.php?controller=auth&action=register');
            }
            
            $userModel = $this->model('User');
            
            if ($userModel->usernameExists($username)) {
                $_SESSION['error'] = 'Username sudah terdaftar';
                $this->redirect('../index.php?controller=auth&action=register');
            }
            
            $data = [
                'username' => $username,
                'password' => md5($password),
                'level' => 'kasir'
            ];
            
            $userId = $userModel->createUser($data);
            
            if ($userId) {
                $_SESSION['success'] = 'Registrasi berhasil. Silakan login';
                $this->redirect('../index.php?controller=auth&action=index');
            } else {
                $_SESSION['error'] = 'Registrasi gagal';
                $this->redirect('../index.php?controller=auth&action=register');
            }
        } else {
            $this->view('auth/register');
        }
    }
}
?>
