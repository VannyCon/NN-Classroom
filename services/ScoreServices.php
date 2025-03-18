<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class ScoreServices extends config {
    public function saveScore($score_id, $studentID, $quizID, $classroomID, $score, $total) {
        try {
            $query = "INSERT INTO `tbl_score` (`score_id`, `student_id_fk`, `quiz_id_fk`, `classroom_id_fk`, `score`, `total`) 
                      VALUES ( :score_id,:student_id, :quiz_id, :classroom_id, :score, :total)
                      ON DUPLICATE KEY UPDATE score = :score";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':score_id' => $score_id,
                ':student_id' => $studentID,
                ':quiz_id' => $quizID,
                ':classroom_id' => $classroomID,
                ':score' => $score,
                ':total' => $total
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error saving score: " . $e->getMessage());
            return false;
        }
    }
}
?>
