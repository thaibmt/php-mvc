<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}
// Yêu cầu vai trò quản lý
if ($_SESSION['role'] != 'HV') {
    echo 'Chỉ HV mới được sử dụng chức năng này!';
    exit();
}
$title = "Thanh toán hóa đơn";
?>
<?php if (isset($_SESSION['message'])) { ?>
<h2 class="text-success"><?php echo $_SESSION['message'] ?></h2>
<?php unset($_SESSION['message']);
} ?>
<h2>Thanh toán</h2>
<form method="post" action="index.php?action=createPayment&id=<?php echo $id ?>" class="form"
    encrypt="multipart/form-data">
    <div class="form-group">
        <label for="">Mã hóa đơn:</label>
        <input type="text" name="id_bill" class="form-control" value="<?php echo $id ?>" required disabled>
    </div>
    <div class="form-group">
        <label for="">Nội dung:</label>
        <textarea name="content" class="form-control"
            placeholder="vd: Đã chuyển khoản với số hóa đơn: ABC0123 vào STK 0122111 ACB"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Thanh toán</button>
</form>
<?php
$content = ob_get_clean();
include('views/master_layout.php');