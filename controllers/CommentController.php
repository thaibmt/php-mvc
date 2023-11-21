<?php
class CommentController
{
    private $commentModel;

    public function __construct($commentModel)
    {
        $this->commentModel = $commentModel;
    }

    public function index($page = 1, $pageSize = 1)
    {
        try {
            $totalComments = $this->commentModel->getTotalCommentCount();
            $totalPages = ceil($totalComments / $pageSize);

            // Đảm bảo trang hiện tại không vượt quá tổng số trang
            $page = max(min($page, $totalPages), 1);
            // Lấy danh sách hóa đơn cho trang hiện tại
            $comments = $this->commentModel->getCommentsPerPage($page, $pageSize);

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
                'student_id' => $_POST['student_id'],
                'content' => $_POST['content'],
                'created_at' => $now,
                'updated_at' => $now
            ];
            $result = $this->commentModel->createComment($data);
        } catch (Exception $e) {
            die($e);
        }
    }

    public function delete($id)
    {
        try {
            $this->commentModel->deleteComment($id);
            // Trở về trang danh sách
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }
}
