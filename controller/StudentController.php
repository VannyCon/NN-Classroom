<?php
require_once('../../../services/StudentServices.php');
$studentService = new StudentServices();

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

    $status = $studentService->registerStudent($student_id, $username, $password, $fullname);
    
    if ($status) {
        header("Location: index.php?success=1");
        exit();
    } else {
        error_log("Registration failed in controller");
        header("Location: register.php?error=Registration failed. Please check error logs.");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'enrollClassroom') {
    if (empty($_POST['code'])) {
        header("Location: dashboard.php?error=Please input a Classroom Code.");
        exit();
    }

    $studentId = $_SESSION['student_id'] ?? null;
    if (!$studentId) {
        header("Location: student.php?error=Student not logged in.");
        exit();
    }

    $code = StudentServices::clean('code', 'post');
    $status = $studentService->enrollClassroom($studentId, $code);

    if ($status['success']) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        header("Location: dashboard.php?error=" . urlencode($status['message']));
        exit();
    }
}

?>