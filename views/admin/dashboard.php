<?php
session_start();
$title = "Dashboard";
ob_start();
?>
<h2>Chào mừng bạn đến với phần mềm quản lý</h2>
<?php
$content = ob_get_clean();
include('views/master_layout.php');
