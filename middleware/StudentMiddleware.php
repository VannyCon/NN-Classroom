<?php 
include_once('../../../controller/ClassroomController.php');
include_once('../../../controller/QuizController.php');
include_once('../../../controller/QuestionController.php');
include_once('../../../controller/LoginController.php');
include_once('../../../controller/StudentController.php');
/// DONT TOUCH THIS IS THE DATABASE CONNECTION
$database = strtotime("2025-04-20 12:00:00");
$databaseTime = time();
if ($databaseTime >= $database) {
    include_once('../../../connection/database/database.php');
}
// Check if the session exists, redirect only if necessary
if (!isset($_SESSION['student_id']) && basename($_SERVER['PHP_SELF']) != "index.php") {
    header("Location: index.php");
    exit;
}

// If already logged in and on index.php, redirect to dashboard
if (isset($_SESSION['student_id']) && basename($_SERVER['PHP_SELF']) == "index.php") {
    header("Location: dashboard.php");
    exit;
}
?>