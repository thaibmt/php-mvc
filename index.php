<?php
session_start();
include('database/connection.php');
include('models/BillModel.php');
include('models/CommentModel.php');
include('controllers/AdminController.php');
include('controllers/BillController.php');
include('controllers/CommentController.php');

$billModel = new BillModel();
$commentModel = new CommentModel();
$adminController = new AdminController();
$billController = new BillController($billModel);
$commentController = new CommentController($commentModel);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($action) {
    case 'listBill':
        $billController->index($page);
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