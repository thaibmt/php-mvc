<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Cập nhật đơn hàng";
ob_start();
?>
<form method="post" action="index.php?action=updateBill&id=<?php echo $id ?>" class="form">
    <div class="form-group">
        <label for="">Học viên:</label>
        <select name="id_hv" class="form-select select" required>
            <?php foreach ($students as $student) { ?>
            <option <?php echo $bill['id_hv'] == $student['id_hv'] ? 'selected' : '' ?>
                value="<?php echo $student['id_hv'] ?>"><?php echo $student['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Lớp học:</label>
        <select name="id_class" class="form-select select" required>
            <?php foreach ($classes as $class) { ?>
            <option <?php echo $bill['id_class'] == $class['id_class'] ? 'selected' : '' ?>
                value="<?php echo $class['id_class'] ?>"><?php echo $class['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Quản lý:</label>
        <select name="id_ql" class="form-select select" required>
            <?php foreach ($managers as $manager) { ?>
            <option <?php echo $bill['id_ql'] == $manager['id_ql'] ? 'selected' : '' ?>
                value="<?php echo $manager['id_ql'] ?>"><?php echo $manager['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Ngày đăng ký:</label>
        <input type="date" name="date_bill" class="form-control" value="<?php echo $bill['date_bill'] ?>">
    </div>
    <div class="form-group">
        <label for="">Tổng tiền:</label>
        <input type="number" min="0" name="total" value="<?php echo $bill['total'] ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
</form>
<?php
$content = ob_get_clean();
include('views/master_layout.php');