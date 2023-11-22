<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}
// Yêu cầu vai trò học viên
if (in_array($_SESSION['role'], ['QL', 'GV'])) {
    echo 'Chỉ học viên và giáo viên mới đăng đánh giá';
    exit();
}
$title = "Đăng đánh giá";
ob_start();
?>
<?php if (isset($message)) { ?>
<h2 class="text-success"><?php echo $message ?></h2>
<?php } ?>
<form method="post" action="index.php?action=createComment">
    <div class="form-group">
        <label>Nội dung đánh giá</label>
        <textarea class="form-control" name="content" placeholder="Nhập nội dung đánh giá" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Đăng</button>
</form>
<?php
$content = ob_get_clean();
include('views/master_layout.php');