<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class QuizServices extends config {
    public function getQuizzes($classroomId) {
        try {
            $query = "SELECT * FROM `tbl_quiz` WHERE `classroom_id_fk` = :classroomId";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':classroomId', $classroomId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function createQuiz($quizId, $quizTitle, $quizDescription, $instructorId, $classroomId, $expiration) {
        try {
            $query = "INSERT INTO `tbl_quiz` (`quiz_id`, `quiz_title`, `quiz_description`, `instructor_id_fk`, `classroom_id_fk`, `isActive`, `expiration`, `created_date`) 
                      VALUES (:quiz_id, :quiz_title, :quiz_description, :instructor_id, :classroom_id, 1, :expiration, NOW())";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quizId);
            $stmt->bindParam(':quiz_title', $quizTitle);
            $stmt->bindParam(':quiz_description', $quizDescription);
            $stmt->bindParam(':instructor_id', $instructorId);
            $stmt->bindParam(':classroom_id', $classroomId);
            $stmt->bindParam(':expiration', $expiration);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateQuiz($quizId, $quizTitle, $quizDescription, $expiration) {
        try {
            $query = "UPDATE `tbl_quiz` SET `quiz_title` = :quiz_title, `quiz_description` = :quiz_description, `expiration` = :expiration WHERE `quiz_id` = :quiz_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quizId);
            $stmt->bindParam(':quiz_title', $quizTitle);
            $stmt->bindParam(':quiz_description', $quizDescription);
            $stmt->bindParam(':expiration', $expiration);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteQuiz($quizId) {
        try {
            $query = "DELETE FROM `tbl_quiz` WHERE `quiz_id` = :quiz_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quizId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
}
?>
