<?php
require_once('../../../services/InstructorServices.php');
$instructor = new InstructorServices();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'registerInstructor') {
    // Debug: Check if form values are coming in
    if (empty($_POST['email']) || empty($_POST['fullname']) || empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: register.php?error=All fields are required.");
        exit();
    }

    // Get and sanitize input values
    $fullname = InstructorServices::clean('fullname', 'post');
    $email = InstructorServices::clean('email', 'post');
    $username = InstructorServices::clean('username', 'post');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (!$password) {
        die("Error hashing password.");
    }

    // Generate unique instructor ID
    $instructor_id = "INSTRUCTOR-" . mt_rand(1000000, 9999999);

    // Check if all fields are still valid after sanitization
    if (!empty($fullname) && !empty($username) && !empty($password)) {
        $status = $instructor->registerInstructor($fullname, $username, $password, $email, $instructor_id);
    
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'changePassword') {
    $instructorId = $_SESSION['instructor_id'] ?? null;
    if (!$instructorId) {
        header("Location: logout.php?error=instructor not logged in.");
        exit();
    }
    
    $old_password = InstructorServices::clean('old_password', 'post');
    $new_password = InstructorServices::clean('new_password', 'post');
    $confirm_password = InstructorServices::clean('confirm_password', 'post');
    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        header("Location: dashboard.php?error=" . urlencode("New passwords do not match."));
        exit();
    }
    $status = $instructor->changePassword($instructorId, $old_password, $new_password);

    if ($status === true) {
        header("Location: logout.php");
    } else {
        header("Location: dashboard.php?error=" . urlencode($status));
    }
}
?>