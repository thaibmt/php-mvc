<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Dashboard";
ob_start();
?>
<div class="container text-center">
    <?php if (isset($_SESSION['message'])) { ?>
    <h2 class="text-success"><?php echo $_SESSION['message'] ?></h2>
    <?php unset($_SESSION['message']);
    } ?>
    <h2>Chào mừng bạn đến với phần mềm quản lý khóa học</h2>
</div>
<?php
$content = ob_get_clean();
include('views/master_layout.php');