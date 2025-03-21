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
    $email = StudentServices::clean('email', 'post');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $student_id = "STUDENT-" . mt_rand(1000000, 9999999);

    // Debug: Print processed data
    error_log("Processed registration data - Student ID: $student_id, Username: $username, Fullname: $fullname");

      // Check if all fields are still valid after sanitization
      if (!empty($fullname) && !empty($username) && !empty($password)) {
        $status = $studentService->registerStudent($student_id, $username, $password, $fullname, $email);
    
        if ($status === true) {
            header("Location: index.php?success=1");
            exit();
        } else {
            header("Location: register.php?error=" . urlencode($status)); // Encode error message for URL
            exit();
        }
    } else {
        header("Location: register.php?error=" . urlencode("All fields are required."));
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



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'changePassword') {
    $studentId = $_SESSION['student_id'] ?? null;
    if (!$studentId) {
        header("Location: student.php?error=Student not logged in.");
        exit();
    }
    
    $old_password = StudentServices::clean('old_password', 'post');
    $new_password = StudentServices::clean('new_password', 'post');
    $confirm_password = StudentServices::clean('confirm_password', 'post');
    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        header("Location: dashboard.php?error=" . urlencode("New passwords do not match."));
        exit();
    }
    $status = $studentService->changePassword($studentId, $old_password, $new_password);

    if ($status === true) {
        header("Location: logout.php");
    } else {
        header("Location: dashboard.php?error=" . urlencode($status));
    }
}
?>