<?php
require_once('../../../services/StudentServices.php');
$student = new StudentServices();

// REGISTER STUDENT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'registerStudent') {
    // Debug: Print received data
    error_log("Received registration request: " . print_r($_POST, true));

    if (empty($_POST['fullname']) || empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: register.php?error=All fields are required.");
        exit();
    }

    $fullname = StudentServices::clean('fullname', 'post');
    $username = StudentServices::clean('username', 'post');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $student_id = "STUDENT-" . mt_rand(1000000, 9999999);

    // Debug: Print processed data
    error_log("Processed registration data - Student ID: $student_id, Username: $username, Fullname: $fullname");

    $status = $student->registerStudent($student_id, $username, $password, $fullname);
    
    if ($status) {
        header("Location: index.php?success=1");
        exit();
    } else {
        error_log("Registration failed in controller");
        header("Location: register.php?error=Registration failed. Please check error logs.");
        exit();
    }
}
?>