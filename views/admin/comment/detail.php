<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit();
}

$title = "Danh sách phản hồi";
ob_start();
?>
<!-- Hiển thị danh sách hóa đơn và các liên kết điều hướng -->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Nội dung đánh giá</h2>
            <span><?php echo $comment['content'] ?></span>
        </div>
        <div class="card-body">
            <div class="d-flex flex-start mt-4">
                <div class="flex-grow-1 flex-shrink-1">
                    <div>
                        <form action="index.php?action=readComment&id=<?php echo $id ?>" method="post" class="form">
                            <div class="form-group">
                                <textarea name="content" class="form-control w-100" cols="200" rows="2" placeholder="Viết phản hồi"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php foreach ($replies as $reply) { ?>
                <div class="d-flex flex-start mt-4">
                    <div class="flex-grow-1 flex-shrink-1">
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-1">
                                    <?php if (isset($reply['id_ql'])) { ?>
                                        <span class="btn btn-primary">John Smith </span><span class="small">- Quản lý</span>
                                    <?php } else { ?>
                                        <span class="btn btn-success">Bạn </span><span class="small"></span>
                                    <?php } ?>
                                </p>
                                <?php if (isset($reply['id_ql']) && $_SESSION['role'] == 'QL') { ?>
                                    <a href="index.php?action=deleteReply&id=<?php echo $reply['id'] ?>" class="btn btn-danger">Xóa</a>
                                <?php } else if (!$reply['id_ql']) { ?>
                                    <a href="index.php?action=deleteReply&id=<?php echo $reply['id'] ?>" class="btn btn-danger">Xóa</a>
                                <?php } ?>
                            </div>
                            <p class="small mb-0">
                                <?php echo $reply['content'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include('views/master_layout.php');
