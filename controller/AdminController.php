<?php 
require_once('../../../services/AdminServices.php');
$admin = new AdminServices();


$getAllNeedApprovalIntructor = $admin->getAllInstructor();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'approvedInstructor') {
    // Retrieve form input
    $id = AdminServices::clean('instructor_id', 'post');
    if (!empty($id)) { 
        $status = $admin->updateStatus($id, 2);
        if($status == true){
            header("Location: dashboard.php");
            exit();
        }else{
            header("Location: dashboard.php?error=1");
        }
    } else {
        $error = "Please fill in both fields.";
    }
}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'rejectInstructor') {
    // Retrieve form input
    $id = AdminServices::clean('instructor_id', 'post');
    if (!empty($id)) { 
        $status = $admin->updateStatus($id, 1);
        if($status == true){
            header("Location: dashboard.php");
            exit();
        }else{
            header("Location: dashboard.php?error=1");
        }
    } else {
        $error = "Please fill in both fields.";
    }
}



?>

