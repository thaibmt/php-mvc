<?php
class AccountModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM account WHERE username = ? AND password = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $password]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}