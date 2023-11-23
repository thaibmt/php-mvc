<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Danh sách thanh toán";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>STT</th>
        <th>Mã HV</th>
        <th>Tên HV</th>
        <!-- <th>Khóa học</th> -->
        <th>Lớp</th>
        <th>Tổng tiền</th>
        <th>Ngày đăng ký</th>
        <th>Tình trạng</th>
        <th class="text-center">Chức năng</th>
    </tr>
    <?php foreach ($bills as $index => $bill) : ?>
    <tr>
        <td><?php echo $index + 1; ?></td>
        <td><?php echo $bill['id_hv']; ?></td>
        <td><?php echo $bill['student_name']; ?></td>
        <!-- <td><?php //echo $bill['course_name']; 
                        ?></td> -->
        <td><?php echo $bill['class_name']; ?></td>
        <td><?php echo $bill['total']; ?></td>
        <td><?php echo $bill['date_bill']; ?></td>
        <td><?php echo $bill['paid'] ? 'Đã thanh toán' : 'Chưa thanh toán'; ?></td>
        <td class="text-center">
            <a class="btn btn-warning" href="index.php?action=updateBill&id=<?php echo $bill['id_bill']; ?>">Sửa</a>
            <a class="btn btn-danger" href="index.php?action=deleteBill&id=<?php echo $bill['id_bill']; ?>">Xóa</a>
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