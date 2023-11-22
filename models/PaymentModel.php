<?php
class PaymentModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        try {
            $sql = "SELECT * FROM payments";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getPaymentByBillId($billId)
    {
        try {
            $sql = "SELECT * FROM payments where id_bill = ?";
            $stmt = $this->pdo->query($sql);
            $stmt->execute([$billId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function create($data)
    {
        try {
            $sql = "INSERT INTO payments (id_bill, content, created_at, updated_at) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            die($e);
            return false;
        }
    }
}
