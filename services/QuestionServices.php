<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class QuestionServices extends config {
    
    public function saveQuestions($questions) {
        try {
            $query = "INSERT INTO `tbl_questions` (`quiz_id_fk`, `question_id`, `number`, `classroom_id_fk`, `question_type`, `question_description`, `answer`, `a`, `b`, `c`, `d`, `image_path`) 
                      VALUES (:quiz_id_fk, :question_id, :number, :classroom_id_fk, :question_type, :question_description, :answer, :a, :b, :c, :d, :image_path)
                      ON DUPLICATE KEY UPDATE 
                      question_description = VALUES(question_description), 
                      answer = VALUES(answer), 
                      a = VALUES(a), 
                      b = VALUES(b), 
                      c = VALUES(c), 
                      d = VALUES(d),
                      image_path = VALUES(image_path)";
    
            $stmt = $this->pdo->prepare($query);
    
            foreach ($questions as $q) {
                $stmt->execute([
                    ':quiz_id_fk' => $q['quiz_id_fk'],
                    ':number' => $q['number'],
                    ':question_id' => $q['question_id'],
                    ':classroom_id_fk' => $q['classroom_id_fk'],
                    ':question_type' => $q['question_type'],
                    ':question_description' => $q['question_description'],
                    ':answer' => $q['answer'],
                    ':a' => $q['a'] ?? null,
                    ':b' => $q['b'] ?? null,
                    ':c' => $q['c'] ?? null,
                    ':d' => $q['d'] ?? null,
                    ':image_path' => $q['image_path']
                ]);
            }
    
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function fetchQuestions($quizID, $classroomID) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tbl_questions WHERE quiz_id_fk = :quiz_id AND classroom_id_fk = :classroom_id ORDER BY number ASC");
            $stmt->execute([
                ':quiz_id' => $quizID,
                ':classroom_id' => $classroomID
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    
}
?>
