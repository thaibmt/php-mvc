<?php
class BillModel extends Database
{
    // public $pdo;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllBills()
    {
        $sql = "SELECT * FROM bill";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBillDetails($billId)
    {
        $sql = "SELECT * FROM bill WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$billId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBillsPerPage($page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM bill LIMIT :offset, :pageSize";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalBillCount()
    {
        $sql = "SELECT COUNT(*) as count FROM bill";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function deleteBill($id)
    {
        try {
            $sql = "DELETE bill where id=$id";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
