<?php
session_start();
$title = "Danh sách đơn hàng";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<table border="1" class="table">
    <tr>
        <th>ID</th>
        <th>Total</th>
    </tr>
    <?php foreach ($bills as $bill) : ?>
        <tr>
            <td><?php echo $bill['id_bill']; ?></td>
            <td><?php echo $bill['total']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $_GET['page'] == $i ? 'active' : '' ?>"><a class="page-link" href="index.php?action=listBill&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php
$content = ob_get_clean();
include('views/master_layout.php');
