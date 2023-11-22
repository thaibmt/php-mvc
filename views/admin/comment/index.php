<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}
// Yêu cầu vai trò quản lý
// if ($_SESSION['role'] != 'QL') {
//     echo 'Chỉ quản lý mới được sử dụng chức năng này!';
//     exit();
// }

$title = "Danh sách phản hồi";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>STT</th>
        <th>Mã</th>
        <th>Tên</th>
        <th>Vai trò</th>
        <th>Nội dung</th>
        <th>Action</th>
    </tr>
    <?php foreach ($comments as $index => $comment) : ?>
    <tr>
        <td><?php echo $index + 1; ?></td>
        <td><?php echo $comment['id_hv'] ?: $comment['id_gv']; ?></td>
        <td><?php echo $comment['studentName'] ?: $comment['lecturerName']; ?></td>
        <td><?php echo $comment['id_gv'] ? 'Giảng viên' : 'Sinh viên'; ?></td>
        <td><?php echo $comment['content']; ?></td>
        <td>
            <a href="index.php?action=readComment&id=<?php echo $comment['id']; ?>" class="btn btn-primary">Chi
                tiết</a>
            <a href="index.php?action=deleteComment&id=<?php echo $comment['id']; ?>" class="btn btn-danger">Xóa</a>
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
                    href="index.php?action=listComment&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php } ?>
<?php
$content = ob_get_clean();
include('views/master_layout.php');