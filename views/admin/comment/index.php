<?php
session_start();
$title = "Danh sách phản hồi";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>STT</th>
        <th>Mã HV</th>
        <th>Tên HV</th>
        <th>Nội dung</th>
        <th>Action</th>
    </tr>
    <?php foreach ($comments as $index => $comment) : ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $comment['id_hv']; ?></td>
            <td><?php echo $comment['name']; ?></td>
            <td><?php echo $comment['content']; ?></td>
            <td>
                <a href="index.php?action=deleteComment&id=<?php echo $comment['id']; ?>" class="btn btn-danger">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $_GET['page'] == $i ? 'active' : '' ?>"><a class="page-link" href="index.php?action=listComment&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php
$content = ob_get_clean();
include('views/master_layout.php');
