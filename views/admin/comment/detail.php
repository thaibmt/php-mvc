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
    <?php if (isset($_SESSION['message'])) { ?>
    <h2 class="text-success"><?php echo $_SESSION['message'] ?></h2>
    <?php unset($_SESSION['message']);
    } ?>
    <div class="card">
        <div class="card-header">
            <div class=" d-flex justify-content-between">
                <h2>Nội dung đánh giá</h2>
                <a href="index.php?action=deleteComment&id=<?php echo $id ?>"
                    class="btn btn-small btn-danger text-white">Xóa phản hồi</a>
            </div>
            <hr>
            <strong><?php echo $comment['content'] ?></strong>
        </div>
        <div class="card-body">
            <div class="d-flex flex-start mt-4">
                <div class="flex-grow-1 flex-shrink-1">
                    <div>
                        <form action="index.php?action=readComment&id=<?php echo $id ?>" method="post" class="form">
                            <div class="form-group">
                                <textarea name="content" class="form-control w-100" cols="200" rows="2"
                                    placeholder="Viết phản hồi"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr />
            <?php foreach ($replies as $reply) { ?>
            <div class="d-flex flex-start mt-4">
                <div class="flex-grow-1 flex-shrink-1 col">
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                                <?php if (isset($reply['id_ql'])) { ?>
                                <strong class="label"><?php echo $reply['name'] ?> </strong><i
                                    class="small text-primary">- Quản
                                    lý</i>
                                <?php } else { ?>
                                <strong class="label"><?php echo $comment['studentName'] ?: $comment['lecturerName']  ?>
                                </strong><i class="small text-success">- <?php echo $comment['role'] == 'GV' ? 'Giảng viên' : 'Sinh
                                    viên' ?></i>
                                <?php } ?>
                            </p>
                            <?php if (isset($reply['id_ql']) && $_SESSION['role'] == 'QL') { ?>
                            <a href="index.php?action=deleteReply&id=<?php echo $reply['id'] ?>"
                                class="btn btn-sm btn-danger">Xóa</a>
                            <?php } else if (!$reply['id_ql']) { ?>
                            <a href="index.php?action=deleteReply&id=<?php echo $reply['id'] ?>"
                                class="btn btn-sm btn-danger">Xóa</a>
                            <?php } ?>
                        </div>
                        <p class="ml-4 small mb-0">
                            <?php echo $reply['content'] ?>
                        </p>
                        <hr />
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