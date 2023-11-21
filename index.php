<?php
session_start();
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
include('database/connection.php');
include('models/BillModel.php');
include('models/CommentModel.php');
include('models/AccountModel.php');
include('models/ManagerModel.php');
include('models/ClassModel.php');
include('models/CourseModel.php');
include('models/StudentModel.php');
include('models/ReplyModel.php');
include('controllers/AdminController.php');
include('controllers/BillController.php');
include('controllers/CommentController.php');

$billModel = new BillModel();
$commentModel = new CommentModel();
$accountModel = new AccountModel();
$managerModel = new ManagerModel();
$classModel = new ClassModel();
$courseModel = new CourseModel();
$studentModel = new StudentModel();
$replyModel = new ReplyModel();
$adminController = new AdminController($accountModel);
$billController = new BillController($billModel, $managerModel, $classModel, $courseModel, $studentModel);
$commentController = new CommentController($commentModel);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($action) {
    case 'logout':
        $adminController->logout();
        break;
    case 'login':
        $adminController->login();
        break;
    case 'listBill':
        $billController->index($page);
        break;
    case 'updateBill':
        $billController->update($id);
        break;
    case 'deleteBill':
        $billController->delete($id);
        break;
    case 'listComment':
        $commentController->index($page);
        break;
    case 'createComment':
        $commentController->create();
        break;
    case 'deleteComment':
        $commentController->delete($id);
        break;
    default:
        $adminController->index();
        break;
}