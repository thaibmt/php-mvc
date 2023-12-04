<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}
// Yêu cầu vai trò quản lý
if ($_SESSION['role'] != 'QL') {
    echo 'Chỉ quản lý mới được sử dụng chức năng này!';
    exit();
}

$title = "Tạo đơn hàng";
ob_start();
?>
<?php if (isset($_SESSION['message'])) { ?>
<h2 class="text-success"><?php echo $_SESSION['message'] ?></h2>
<?php unset($_SESSION['message']);
} ?>
<form method="post" action="index.php?action=createBill" class="form">
    <div class="form-group">
        <label for="">ID Bill:</label>
        <input type="text" name="id_bill" class="form-control" value="" required>
    </div>
    <div class="form-group">
        <label for="">Học viên:</label>
        <select name="id_hv" class="form-select select" required>
            <?php foreach ($students as $student) { ?>
            <option value="<?php echo $student['id_hv'] ?>"><?php echo $student['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Lớp học:</label>
        <select name="id_class" class="form-select select" required>
            <?php foreach ($classes as $class) { ?>
            <option value="<?php echo $class['id_class'] ?>"><?php echo $class['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Quản lý:</label>
        <select name="id_ql" class="form-select select" required>
            <?php foreach ($managers as $manager) { ?>
            <option value="<?php echo $manager['id_ql'] ?>"><?php echo $manager['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Ngày đăng ký:</label>
        <input type="date" name="date_bill" class="form-control" value="<?php echo date("Y-m-d"); ?>">
    </div>
    <div class="form-group">
        <label for="">Tổng tiền:</label>
        <input type="number" min="0" name="total" value="0" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Trạng thái:</label>
        <select name="paid" class="form-select select" required>
            <option value="0">Chưa thanh toán</option>
            <option value="1">Đã thanh toán</option>
            <option value="2">Chờ duyệt thanh toán</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
</form>
<?php
$content = ob_get_clean();
include('views/master_layout.php');