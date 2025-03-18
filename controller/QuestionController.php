<?php
require_once('../../../services/QuestionServices.php');
require_once('../../../services/ScoreServices.php');

$questionServices = new QuestionServices();
$scoreServices = new ScoreServices();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['questions']) && $_POST['action'] == 'createQuestions') {
    $questions = [];

    foreach ($_POST['questions'] as $index => $q) {
        $imagePath = null;

        // Check if an image is uploaded for this question
        if (isset($_FILES['questions']['name'][$index]['image_path']) && $_FILES['questions']['error'][$index]['image_path'] == UPLOAD_ERR_OK) {
            $uploadDir = "../../../data/images/" . $_POST['quiz_id_fk'] . "/";

            // Ensure directory exists
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                die("Failed to create image directory.");
            }

            $fileTmpPath = $_FILES['questions']['tmp_name'][$index]['image_path'];
            $fileName = basename($_FILES['questions']['name'][$index]['image_path']);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                $newFileName = uniqid("question_" . $_POST['quiz_id_fk'] . "_") . "." . $fileExtension;
                $destinationPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                    $imagePath = $destinationPath; // Remove relative path for DB
                }
            }
        }

        // Append question details
        $questions[] = [
            'quiz_id_fk' => $_POST['quiz_id_fk'],
            'number' => $index + 1,
            'question_id' => $_POST['quiz_id_fk'] . "_" . ($index + 1),
            'classroom_id_fk' => $_POST['classroom_id_fk'],
            'question_type' => $q['question_type'],
            'question_description' => $q['question_description'],
            'answer' => $q['answer'],
            'a' => $q['a'] ?? null,
            'b' => $q['b'] ?? null,
            'c' => $q['c'] ?? null,
            'd' => $q['d'] ?? null,
            'image_path' => $imagePath
        ];
    }

    $classroomId = $_POST['classroom_id_fk'];

    if ($questionServices->saveQuestions($questions)) {
        header("Location: success_creation_quiz.php?classroom_id=$classroomId&success=Questions saved successfully!");
        exit();
    } else {
        echo "Error saving questions.";
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answers'])) {
    // Handle the request
    $quizID = $_GET['quiz_id'] ?? null;
    $classroomID = $_GET['classroom_id'] ?? null;
    $studentID = $_GET['student_id'] ?? null;

    // Fetch questions again before scoring
    $questions = $questionServices->fetchQuestions($quizID, $classroomID);
    $correct = 0;
    $total = count($questions);

    foreach ($questions as $q) {
        $questionID = $q['question_id'];
        $correctAnswer = strtolower(trim($q['answer']));
        $studentAnswer = strtolower(trim($_POST['answers'][$questionID] ?? ''));

        if ($studentAnswer === $correctAnswer) {
            $correct++;
        }
    }

    $score_id = "SCORE-" . mt_rand(1000000, 9999999);
    $score =  $correct;


    $scoreServices->saveScore($score_id, $studentID, $quizID, $classroomID, $score, $total);

    header("Location: result.php?&score=$score&classroom_id=$classroomID&total=$total");
    exit();
}

?>
