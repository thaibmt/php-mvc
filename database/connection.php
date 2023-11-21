<?php

class Database
{
    public $pdo;
    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }
    public function getConnection()
    {
        $db = "qlkhoahoc";
        $host = "mysql";
        $dsn = "mysql:dbname=$db;host=$host";
        $user = 'root';
        $pass = 'root';
        try {
            $pdo = new PDO($dsn, $user, $pass);
            // Thiết lập chế độ lỗi và chế độ ngoại lệ
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
            return $this->pdo;
        } catch (Exception $e) {
            die('Kết nối không thành công: ' . $e->getMessage());
        }
    }
}