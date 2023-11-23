<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Danh sách phản hồi";
ob_start();
?>
<?php if (isset($_SESSION['message'])) { ?>
<h2 class="text-success"><?php echo $_SESSION['message'] ?></h2>
<?php unset($_SESSION['message']);
} ?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>STT</th>
        <th>Mã</th>
        <th>Tên</th>
        <th>Vai trò</th>
        <th>Nội dung</th>
        <th class="text-center">Chức năng</th>
    </tr>
    <?php foreach ($comments as $index => $comment) : ?>
    <tr>
        <td><?php echo $index + 1; ?></td>
        <td><?php echo isset($comment['id_hv']) ? $comment['id_hv'] : $comment['id_gv']; ?></td>
        <td><?php echo isset($comment['studentName']) ? $comment['studentName'] : $comment['lecturerName']; ?></td>
        <td><?php echo isset($comment['id_gv']) ? 'Giảng viên' : 'Sinh viên'; ?></td>
        <td><?php echo $comment['content']; ?></td>
        <td class="text-center">
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