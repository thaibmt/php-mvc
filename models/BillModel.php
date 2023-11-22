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
        $sql = "SELECT bill.*, payments.content as content FROM bill
        LEFT JOIN payments ON bill.id_bill = payments.id_bill
        WHERE bill.id_bill = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$billId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBillsPerPage($page, $pageSize, $userId = null)
    {
        $offset = ($page - 1) * $pageSize;
        if ($userId) {
            $sql = "SELECT bill.*, class.name as class_name, manager.name as manager_name, student.name as student_name, course.name as course_name, payments.content as content FROM bill
            INNER JOIN class ON bill.id_class = class.id_class 
            INNER JOIN manager On bill.id_ql = manager.id_ql
            INNER JOIN student On bill.id_hv = student.id_hv
            INNER JOIN course On class.id_course = course.id_course
            LEFT JOIN payments ON bill.id_bill = payments.id_bill
            WHERE bill.id_hv = :userID 
            LIMIT :offset, :pageSize";
        } else {
            $sql = "SELECT bill.*, class.name as class_name, manager.name as manager_name, student.name as student_name, course.name as course_name, payments.content as content FROM bill
            INNER JOIN class ON bill.id_class = class.id_class 
            INNER JOIN manager On bill.id_ql = manager.id_ql
            INNER JOIN student On bill.id_hv = student.id_hv
            INNER JOIN course On class.id_course = course.id_course
            LEFT JOIN payments ON bill.id_bill = payments.id_bill
            LIMIT :offset, :pageSize";
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

    public function getTotalBillCount($userId = null)
    {
        if ($userId) {
            $sql = "SELECT COUNT(*) as count FROM bill where id_hv = $userId ";
        } else {
            $sql = "SELECT COUNT(*) as count FROM bill";
        }
        $stmt = $this->pdo->query($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function update($data)
    {
        try {
            $sql = "UPDATE bill SET id_hv = ?, id_ql = ?, id_class=? ,date_bill = ?, total = ?, paid = ? WHERE id_bill = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteBill($id)
    {
        try {
            $sql = "DELETE FROM bill WHERE id_bill = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updatePaidStatus($id, $status)
    {
        try {
            $sql = "UPDATE bill SET paid = ? WHERE id_bill = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}