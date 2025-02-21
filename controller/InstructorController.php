<?php
require_once('../../../services/InstructorServices.php');
$instructor = new InstructorServices();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'registerInstructor') {
    // Debug: Check if form values are coming in
    if (empty($_POST['fullname']) || empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: register.php?error=All fields are required.");
        exit();
    }

    // Get and sanitize input values
    $fullname = InstructorServices::clean('fullname', 'post');
    $username = InstructorServices::clean('username', 'post');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (!$password) {
        die("Error hashing password.");
    }
    

    // Generate unique instructor ID
    $instructor_id = "INSTRUCTOR-" . mt_rand(1000000, 9999999);

    // Check if all fields are still valid after sanitization
    if (!empty($fullname) && !empty($username) && !empty($password)) {
        $status = $instructor->registerInstructor($fullname, $username, $password, $instructor_id);
        if ($status) {
            header("Location: index.php?success=1");
            exit();
        } else {
            header("Location: register.php?error=Registration failed. Try again.");
            exit();
        }
    } else {
        header("Location: register.php?error=All fields are required.");
        exit();
    }
}
?>