<?php 
include_once('../../../controller/QuizController.php');

if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
    $scores = $quizService->getQuizScore($quiz_id); // Call your method to get scores
    echo json_encode($scores); // Return the scores as JSON
}

?>