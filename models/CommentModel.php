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

    public function getCommentsPerPage($page, $pageSize, $userId = '', $role = '')
    {
        $offset = ($page - 1) * $pageSize;
        if ($role == 'HV') {
            $sql = "SELECT comments.*, student.name as studentName FROM comments 
            INNER JOIN student ON comments.id_hv = student.id_hv 
            WHERE comments.id_hv = :userID ORDER BY comments.id DESC
            LIMIT :offset, :pageSize  ";
        } else if ($role == 'GV') {
            $sql = "SELECT comments.*, lecturer.name as lecturerName FROM comments 
            INNER JOIN lecturer ON comments.id_gv = lecturer.id_gv 
            WHERE comments.id_gv = :userID  ORDER BY comments.id DESC
            LIMIT :offset, :pageSize ";
        } else {
            $sql = "SELECT comments.*, student.name as studentName, lecturer.name as lecturerName FROM comments 
            LEFT JOIN student ON comments.id_hv = student.id_hv 
            LEFT JOIN lecturer ON comments.id_gv = lecturer.id_gv 
            ORDER BY comments.id DESC
            LIMIT :offset, :pageSize ";
            $userId = null;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        if ($userId) {
            $stmt->bindParam(':userID', $userId, PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCommentCount($userId = '', $role = '')
    {
        if ($role == 'HV') {
            $sql = "SELECT COUNT(*) as count FROM comments where id_hv=$userId";
        } else if ($role == 'GV') {
            $sql = "SELECT COUNT(*) as count FROM comments where id_gv=$userId";
        } else {
            $sql = "SELECT COUNT(*) as count FROM comments";
        }

        $stmt = $this->pdo->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function createComment($data)
    {
        try {
            $sql = "INSERT INTO comments (id_hv, id_gv, role,content, created_at, updated_at) VALUES (?, ?, ?, ?)";
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

    public function findCommentByUserIdAndRole($commentId, $userId, $role)
    {
        try {
            if ($role == 'GV') {
                $sql = "SELECT * FROM comments
                WHERE comments.id = ?
                AND comments.id_gv = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$commentId, $userId]);
            } else if ($role == 'HV') {
                $sql = "SELECT * FROM comments
                WHERE comments.id = ?
                AND comments.id_hv = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$commentId, $userId]);
            } else {
                $sql = "SELECT * FROM comments
                WHERE comments.id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$commentId]);
            }

            return count($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return false;
        }
    }
}
