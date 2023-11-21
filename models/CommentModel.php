<?php
class CommentModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllComments()
    {
        $sql = "SELECT * FROM comments";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentDetails($commentId)
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCommentsPerPage($page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM comments INNER JOIN student ON comments.student_id = student.id_hv LIMIT :offset, :pageSize";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCommentCount()
    {
        $sql = "SELECT COUNT(*) as count FROM comments";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function createComment($data)
    {
        try {
            $sql = "INSERT INTO comments (student_id, content, created_at, updated_at) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteComment($id)
    {
        try {
            $sql = "DELETE FROM comments WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}