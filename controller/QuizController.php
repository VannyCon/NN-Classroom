<?php 
require_once('../../../services/QuizServices.php');
$quizService = new QuizServices();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'createQuiz' && isset($_GET['classroom_id'])) {
        $quizTitle = $_POST['quiz_title'];
        $quizDescription = $_POST['quiz_description'];
        $instructorId = $_SESSION['instructor_id'];
        $classroomId = $_GET['classroom_id'];
        $expiration = $_POST['expiration'];
        $quizId = 'QUIZ-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $status = $quizService->createQuiz($quizId, $quizTitle, $quizDescription, $instructorId, $classroomId, $expiration);
        
        header("Location: classroom.php?classroom_id=".$_GET['classroom_id']."&" . ($status ? "success=Quiz created successfully." : "error=Failed to create quiz."));
        exit();
    }

    if ($action == 'updateQuiz') {
        $quizId = $_POST['quiz_id'];
        $quizTitle = $_POST['quiz_title'];
        $quizDescription = $_POST['quiz_description'];
        $expiration = $_POST['expiration'];
        $status = $quizService->updateQuiz($quizId, $quizTitle, $quizDescription, $expiration);

        header("Location: classroom.php?classroom_id=".$_GET['classroom_id']."&success=" . ($status ? "Quiz updated successfully." : "Failed to update quiz."));
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'deleteQuiz') {
    $quizId = $_POST['quiz_id'];
    
    $status = $quizService->deleteQuiz($quizId);
    
    if ($status) {
        header("Location: classroom.php?classroom_id=".$_GET['classroom_id']."&success=Quiz deleted successfully.");
    } else {
        header("Location: classroom.php?error=Failed to delete quiz.");
    }
    exit();
}

?>
