<?php
class BillController
{
    private $billModel;
    private $managerModel;
    private $classModel;
    private $courseModel;
    private $studentModel;

    public function __construct($billModel, $managerModel, $classModel, $courseModel, $studentModel)
    {
        $this->billModel = $billModel;
        $this->managerModel = $managerModel;
        $this->classModel = $classModel;
        $this->courseModel = $courseModel;
        $this->studentModel = $studentModel;
    }

    public function index($page = 1, $pageSize = 10)
    {
        try {
            $totalBills = $this->billModel->getTotalBillCount();
            $totalPages = ceil($totalBills / $pageSize);

            // Đảm bảo trang hiện tại không vượt quá tổng số trang
            $page = max(min($page, $totalPages), 1);
            // Lấy danh sách hóa đơn cho trang hiện tại
            $bills = $this->billModel->getBillsPerPage($page, $pageSize);

            // Load view với dữ liệu hóa đơn và thông tin phân trang
            include('views/admin/bill/index.php');
        } catch (Exception $e) {
            die($e);
        }
    }

    public function update($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $managers = $this->managerModel->all();
                $classes = $this->classModel->all();
                $courses = $this->courseModel->all();
                $students = $this->studentModel->all();
                $bill = $this->billModel->getBillDetails($id);
                return include('views/admin/bill/update.php');
            }
            $data = [
                'id_hv ' => $_POST['id_hv'],
                'id_ql ' => $_POST['id_ql'],
                'id_class' => $_POST['id_class'],
                'date_bill' => $_POST['date_bill'],
                'total' => $_POST['total'],
                'id_bill' => $id
            ];
            $result = $this->billModel->update($data);
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            die($e);
        }
    }


    public function delete($id)
    {
        try {
            $res = $this->billModel->deleteBill($id);
            // Trở về trang danh sách
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }
}