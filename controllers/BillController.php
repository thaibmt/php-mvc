<?php
class BillController
{
    private $billModel;
    private $managerModel;
    private $classModel;
    private $courseModel;
    private $studentModel;
    private $paymentModel;
    const CHO_THANH_TOAN = 2;
    const DA_THANH_TOAN = 1;
    const CHUA_THANH_TOAN = 0;
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
            $role = $_SESSION['role'];
            if ($role != 'HV') {
                $user_id = null;
            }
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
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $managers = $this->managerModel->all();
                $classes = $this->classModel->all();
                $courses = $this->courseModel->all();
                $students = $this->studentModel->all();
                return include('views/admin/bill/create.php');
            }
            if ($this->billModel->exists($_POST['id_bill'])) {
                $_SESSION['message'] = 'ID Bill đã tồn tại';
                // Trở về trang danh sách
                return header('Location: index.php?action=createBill');
            }
            $now = date("Y-m-d H:i:s");
            $status = (int)$_POST['paid'];
            $data = [
                'id_bill ' => $_POST['id_bill'],
                'id_hv ' => $_POST['id_hv'],
                'id_ql ' => $_POST['id_ql'],
                'id_class' => $_POST['id_class'],
                'date_bill' => $_POST['date_bill'],
                'total' => $_POST['total'],
                'paid' => in_array($status, [0, 1, 2]) ? $status : 0
            ];
            $result = $this->billModel->create($data);
            $_SESSION['message'] = $result ? 'Thành công' : 'Có lỗi xảy ra';
            // Trở về trang danh sách
            header('Location: index.php?action=listBill');
        } catch (Exception $e) {
            return var_dump($e);
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
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
            $status = (int)$_POST['paid'];
            $data = [
                'id_hv ' => $_POST['id_hv'],
                'id_ql ' => $_POST['id_ql'],
                'id_class' => $_POST['id_class'],
                'date_bill' => $_POST['date_bill'],
                'total' => $_POST['total'],
                'paid' => in_array($status, [0, 1, 2]) ? $status : 0,
                'id_bill' => $id
            ];
            $result = $this->billModel->update($data);
            $_SESSION['message'] = $result ? 'Thành công' : 'Có lỗi xảy ra';
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


    public function delete($id)
    {
        try {
            // xóa các payment
            $this->paymentModel->deletePaymentByBillId($id);
            // xóa hóa đơn
            $result = $this->billModel->deleteBill($id);
            $_SESSION['message'] = $result ? 'Thành công' : 'Có lỗi xảy ra';
            // Trở về trang danh sách
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            die($e);
        }
    }

    public function createPayment($id)
    {
        $role = $_SESSION['role'];
        // check bill status
        $bill = $this->billModel->getBillDetails($id);
        if (in_array($bill['paid'], [self::DA_THANH_TOAN, self::CHO_THANH_TOAN])) {
            // $_SESSION['message'] = 'Hóa đơn đã trong trạng thái chờ duyệt hoặc đã thanh toán!';
            // Trở về
            return header('Location: index.php?action=listBill');
        }
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
            // Chuyển bill thành chờ duyệt thanh toán

            $this->billModel->updatePaidStatus($id, self::CHO_THANH_TOAN);
            $_SESSION['message'] = $result ? 'Thành công' : 'Có lỗi xảy ra';
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function approvedBill($id)
    {
        try {
            $res = $this->billModel->updatePaidStatus($id, self::DA_THANH_TOAN);
            // die(var_dump([$res, $id, self::DA_THANH_TOAN]));
            $_SESSION['message'] =  $res ? 'Đã thanh toán hóa đơn thành công.' : 'Có lỗi khi thanh toán hóa đơn!';
            // Trở về
            return header('Location: index.php?action=listBill');
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            // Trở về
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}