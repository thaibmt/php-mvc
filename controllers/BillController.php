<?php
class BillController
{
    private $billModel;
    private $managerModel;
    private $classModel;
    private $courseModel;
    private $studentModel;
    private $paymentModel;

    public function __construct($billModel, $managerModel, $classModel, $courseModel, $studentModel, $paymentModel)
    {
        $this->billModel = $billModel;
        $this->managerModel = $managerModel;
        $this->classModel = $classModel;
        $this->courseModel = $courseModel;
        $this->studentModel = $studentModel;
        $this->paymentModel = $paymentModel;
    }

    public function index($page = 1, $pageSize = 10)
    {
        try {
            $user_id = $_SESSION['user_id'];

            $totalBills = $this->billModel->getTotalBillCount($user_id);
            $totalPages = ceil($totalBills / $pageSize);

            // Đảm bảo trang hiện tại không vượt quá tổng số trang
            $page = max(min($page, $totalPages), 1);
            // Lấy danh sách hóa đơn cho trang hiện tại
            $bills = $this->billModel->getBillsPerPage($page, $pageSize, $user_id);

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
                'paid' => $_POST['paid'],
                'id_bill' => $id
            ];
            $result = $this->billModel->update($data);
            $message = $result ? 'Thành công' : 'Có lỗi xảy ra';
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

    public function payment()
    {
        try {
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            $payments = $this->paymentModel->getPaymentByUserIdAndRole($user_id, $role);

            // Load view với dữ liệu hóa đơn và thông tin phân trang
            include('views/payment/index.php');
        } catch (PDOException $e) {
            die($e);
        }
    }

    public function createPayment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Load view với dữ liệu hóa đơn và thông tin phân trang
            return include('views/payment/create.php');
        }
        $now = date("Y-m-d H:i:s");
        $data = [
            'id_bill' => $id,
            'content ' => $_POST['content'],
            'created_at' =>  $now,
            'updated_at' =>  $now,
        ];
        try {
            if (!$this->billModel->getBillDetails($data['id_bill'])) {
                $_SESSION['message'] = 'Không tìm thấy mã hóa đơn!';
                // Trở về
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            $result = $this->paymentModel->create($data);
            $_SESSION['message'] = $result ? 'Thành công' : 'Có lỗi xảy ra';
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die(var_dump($e));
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
