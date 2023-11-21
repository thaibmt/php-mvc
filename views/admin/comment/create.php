<?php
session_start();
$title = "Tạo phản hồi";
ob_start();
?>
<form method="post" action="index.php?action=createComment">
    <input type="hidden" name="student_id" value="1000">
    <div class="form-group">
        <label>Nội dung phản hồi</label>
        <textarea class="form-control" name="content" placeholder="Nhập nội dung phản hồi" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Đăng</button>
</form>
<?php
$content = ob_get_clean();
include('views/master_layout.php');
