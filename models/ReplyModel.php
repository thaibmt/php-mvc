<?php
class ReplyModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $sql = "SELECT * FROM reply";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getReplyByCommentId($commentId)
    {
        try {
            $sql = "SELECT reply.*, manager.name FROM reply
            LEFT JOIN manager ON reply.id_ql = manager.id_ql
            WHERE reply.comment_id = ?
            ORDER BY reply.id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$commentId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findReplyByUserIdAndRole($replyId, $userId, $role)
    {
        try {
            if ($role == 'GV') {
                $sql = "SELECT * FROM reply
                JOIN comments
                ON reply.comment_id = comments.id
                WHERE reply.id = ?
                AND comments.id_gv = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$replyId, $userId]);
            } else if ($role == 'HV') {
                $sql = "SELECT * FROM reply
                INNER JOIN comments
                ON reply.comment_id = comments.id
                WHERE reply.id = ?
                AND comments.id_hv = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$replyId, $userId]);
            } else {
                $sql = "SELECT * FROM reply
                WHERE reply.id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$replyId]);
            }

            return count($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $sql = "INSERT INTO reply (comment_id, content, id_ql, created_at, updated_at) VALUES (?, ?, ?, ?,?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            die($e);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM reply WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteReplyByCommentId($commentId)
    {
        try {
            $sql = "DELETE FROM reply WHERE comment_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$commentId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}