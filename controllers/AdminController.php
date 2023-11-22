<?php
class AdminController
{
    private $accountModel;

    public function __construct($accountModel)
    {
        $this->accountModel = $accountModel;
    }

    public function index()
    {
        include('views/admin/dashboard.php');
    }

    public function login()
    {
        // Kiểm tra xem có dữ liệu được submit từ form không
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ form
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Gọi phương thức từ Model để kiểm tra đăng nhập
            $user = $this->accountModel->login($username, $password);
            // Kiểm tra kết quả đăng nhập
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];

                // Chuyển hướng đến trang chính hoặc trang sau khi đăng nhập thành công
                header("Location: index.php");
                exit();
            } else {
                echo "Login failed. Invalid username or password.";
            }
        }
        return include('views/auth/login.php');
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=login");
    }
}