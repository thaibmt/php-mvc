<?php
class BillController
{
    private $billModel;

    public function __construct($billModel)
    {
        $this->billModel = $billModel;
    }

    public function index($page = 1, $pageSize = 1)
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
}
