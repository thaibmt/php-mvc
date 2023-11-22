<?php
class CommentController
{
    private $commentModel;
    private $replyModel;

    public function __construct($commentModel, $replyModel)
    {
        $this->commentModel = $commentModel;
        $this->replyModel = $replyModel;
    }

    public function index($page = 1, $pageSize = 10)
    {
        try {
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];

            $totalComments = $this->commentModel->getTotalCommentCount($user_id, $role);
            $totalPages = ceil($totalComments / $pageSize);

            // Đảm bảo trang hiện tại không vượt quá tổng số trang
            $page = max(min($page, $totalPages), 1);
            // Lấy danh sách hóa đơn cho trang hiện tại
            $comments = $this->commentModel->getCommentsPerPage($page, $pageSize, $user_id, $role);
            // Load view với dữ liệu hóa đơn và thông tin phân trang
            include('views/admin/comment/index.php');
        } catch (Exception $e) {
            die($e);
        }
    }

    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                return include('views/admin/comment/create.php');
            }
            $now = date("Y-m-d H:i:s");
            $data = [
                'id_hv' => $_SESSION['role'] == 'HV' ? $_SESSION['user_id'] : null,
                'id_gv' => $_SESSION['role'] == 'GV' ? $_SESSION['user_id'] : null,
                'role' => $_SESSION['role'],
                'content' => $_POST['content'],
                'created_at' => $now,
                'updated_at' => $now
            ];
            $result = $this->commentModel->createComment($data);
            $message = $result ? 'Đã đăng phản hồi thành công.' : 'Có lỗi xảy ra khi đăng phản hồi!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            echo 'Có lỗi xảy ra khi đăng phản hồi!';
            die($e);
        }
    }

    public function delete($id)
    {
        try {
            $role =  $_SESSION['role'];
            $canDelete = true;
            if ($role != 'QL') {
                // kiểm tra reply có xóa được không
                $userId = $_SESSION['user_id'];
                $canDelete = $this->commentModel->findCommentByUserIdAndRole($id, $userId, $role);
            }
            if ($canDelete) {
                // xóa các reply
                $this->replyModel->deleteReplyByCommentId($id);
                // xóa comment
                $this->commentModel->deleteComment($id);
            } else {
                $_SESSION['message'] = 'Không có quyền xóa đánh giá.';
            }

            // Trở về trang danh sách
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }

    public function deleteReply($id)
    {
        try {
            $role =  $_SESSION['role'];
            $canDelete = true;
            if ($role != 'QL') {
                // kiểm tra reply có xóa được không
                $userId = $_SESSION['user_id'];
                $canDelete = $this->replyModel->findReplyByUserIdAndRole($id, $userId, $role);
            }
            if ($canDelete) {
                $this->replyModel->delete($id);
            } else {
                $_SESSION['message'] = 'Không có quyền xóa phản hồi.';
            }
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }

    public function read($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $comment = $this->commentModel->getCommentDetails($id);
                // danh sách phản hồi
                $replies = $this->replyModel->getReplyByCommentId($id);

                return include('views/admin/comment/detail.php');
            }
            $now = date("Y-m-d H:i:s");
            $data = [
                'comment_id' => $id,
                'content' => $_POST['content'],
                'id_ql' => $_SESSION['role'] == 'QL' ? $_SESSION['user_id'] : null,
                'created_at' => $now,
                'updated_at' => $now
            ];
            $result = $this->replyModel->create($data);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }
}
