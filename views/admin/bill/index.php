<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}
// Yêu cầu vai trò quản lý
if (!in_array($_SESSION['role'], ['QL', 'HV'])) {
    echo 'Chỉ quản lý hoặc học viên mới được sử dụng chức năng này!';
    exit();
}

$title = "Danh sách đơn hàng";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>ID</th>
        <th>Mã HV</th>
        <th>Tên HV</th>
        <!-- <th>Khóa học</th> -->
        <th>Lớp</th>
        <th>Tổng tiền</th>
        <th>Ngày đăng ký</th>
        <th>Tình trạng</th>
        <th class="text-center">Action</th>
    </tr>
    <?php foreach ($bills as $index => $bill) : ?>
    <tr>
        <td><?php echo $bill['id_bill']; ?></td>
        <td><?php echo $bill['id_hv']; ?></td>
        <td><?php echo $bill['student_name']; ?></td>
        <!-- <td><?php //echo $bill['course_name']; 
                        ?></td> -->
        <td><?php echo $bill['class_name']; ?></td>
        <td><?php echo $bill['total']; ?></td>
        <td><?php echo $bill['date_bill']; ?></td>
        <td><?php echo $bill['paid'] ? 'Đã thanh toán' : 'Chưa thanh toán'; ?></td>
        <td class="text-center">
            <?php if ($_SESSION['role'] == 'QL') { ?>
            <a class="btn btn-warning" href="index.php?action=updateBill&id=<?php echo $bill['id_bill']; ?>">Sửa</a>
            <a class="btn btn-danger" href="index.php?action=deleteBill&id=<?php echo $bill['id_bill']; ?>">Xóa</a>
            <?php } ?>
            <?php if ($_SESSION['role'] == 'HV') { ?>
            <a class="btn btn-success" href="index.php?action=createPayment&id=<?php echo $bill['id_bill']; ?>">Thanh
                toán</a>
            <?php } ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if ($totalPages > 1) { ?>
<div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo $_GET['page'] == $i ? 'active' : '' ?>"><a class="page-link"
                    href="index.php?action=listBill&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php } ?>
<?php
$content = ob_get_clean();
include('views/master_layout.php');