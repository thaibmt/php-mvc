<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Dashboard";
ob_start();
?>
<h2>Chào mừng bạn đến với phần mềm quản lý</h2>
<?php
$content = ob_get_clean();
include('views/master_layout.php');