<?php
class ManagerModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $sql = "SELECT * FROM manager";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die(var_dump($e));
            return false;
        }
    }
}