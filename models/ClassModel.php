<?php
class ClassModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $sql = "SELECT * FROM class";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}