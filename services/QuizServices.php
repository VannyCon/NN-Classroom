<?php
require_once("../../../middleware/Middleware.php");

class QuizServices extends config {
    public function getQuizzes($classroomId, $studentId) {
        try {
            $query = "
                SELECT q.*,
                       s.*, 
                       CASE 
                           WHEN s.student_id_fk IS NOT NULL THEN 1 
                           ELSE 0 
                       END AS taken 
                FROM tbl_quiz q
                LEFT JOIN tbl_score s 
                    ON q.quiz_id = s.quiz_id_fk 
                    AND s.student_id_fk = :studentId
                WHERE q.classroom_id_fk = :classroomId
                ORDER BY `created_date` DESC
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':classroomId', $classroomId);
            $stmt->bindParam(':studentId', $studentId);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getInsQuizzes($classroomId) {
        try {
            $query = "SELECT q.*, 
                             CASE 
                                 WHEN EXISTS (SELECT 1 FROM tbl_questions tq WHERE tq.quiz_id_fk = q.quiz_id) 
                                 THEN 1 
                                 ELSE 0 
                             END AS has_questions 
                      FROM tbl_quiz q 
                      WHERE q.classroom_id_fk = :classroomId";
                      
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':classroomId', $classroomId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    

    public function getQuizScore($quiz_id) {
        try {
            $query = "SELECT 
                             s.id AS score_id, 
                            s.score_id, 
                            s.classroom_id_fk, 
                            c.classroom_title, 
                            c.classroom_description, 
                            s.quiz_id_fk, 
                            q.quiz_title, 
                            q.quiz_description, 
                            s.student_id_fk, 
                            st.student_fullname, 
                            s.score, 
                            s.total, 
                            c.instructor_id_fk, 
                            i.instructor_fullname
                        FROM tbl_score s
                        JOIN tbl_quiz q ON s.quiz_id_fk = q.quiz_id
                        JOIN tbl_student st ON s.student_id_fk = st.student_id
                        JOIN tbl_classroom c ON s.classroom_id_fk = c.classroom_id
                        JOIN tbl_instructor i ON c.instructor_id_fk = i.instructor_id
                        WHERE s.quiz_id_fk=:quiz_id";
                    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quiz_id);
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


    
    // Function to copy quiz and its questions
    public function copyQuiz($quizId, $newClassroomId) {
        global $pdo;

        // Step 1: Fetch the original quiz
        $stmt = $this->pdo->prepare("SELECT * FROM tbl_quiz WHERE quiz_id = :quizId");
        $stmt->execute(['quizId' => $quizId]);
        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$quiz) {
            return "Quiz not found.";
        }

        // Step 2: Check if the quiz already exists in the new classroom
        $stmt = $this->pdo->prepare("SELECT * FROM tbl_quiz WHERE quiz_id = :quiz_id AND classroom_id_fk = :newClassroomId");
        $stmt->execute(['quiz_id' => $quiz['quiz_id'], 'newClassroomId' => $newClassroomId]);
        $existingQuiz = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingQuiz) {
            return "A quiz with the same ID already exists in the target classroom.";
        }

        // Step 3: Insert the quiz into the new classroom
        $newQuizInsertID = 'QUIZ-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $this->pdo->prepare("INSERT INTO tbl_quiz (quiz_id, quiz_title, quiz_description, instructor_id_fk, classroom_id_fk, isActive, expiration, created_date) 
                                VALUES (:quiz_id, :quiz_title, :quiz_description, :instructor_id_fk, :newClassroomId, :isActive, :expiration, NOW())");
        if (!$stmt->execute([
            'quiz_id' => $newQuizInsertID,
            'quiz_title' => $quiz['quiz_title'],
            'quiz_description' => $quiz['quiz_description'],
            'instructor_id_fk' => $quiz['instructor_id_fk'],
            'newClassroomId' => $newClassroomId,
            'isActive' => $quiz['isActive'],
            'expiration' => $quiz['expiration']
        ])) {
            return "Failed to insert the quiz into the new classroom.";
        }

        // Step 4: Fetch the questions associated with the original quiz
        $stmt = $this->pdo->prepare("SELECT * FROM tbl_questions WHERE quiz_id_fk = :quizId");
        $stmt->execute(['quizId' => $quizId]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Step 5: Insert each question into the new quiz
        foreach ($questions as $question) {
            $newQuestionId = $newQuizInsertID . "_" . $question['number']; // Create a new unique question ID
            $stmt = $this->pdo->prepare("INSERT INTO tbl_questions (quiz_id_fk, question_id, number, classroom_id_fk, question_type, question_description, question_imagepath, answer, a, b, c, d) 
                                    VALUES (:newQuizId, :question_id, :number, :newClassroomId, :question_type, :question_description, :question_imagepath, :answer, :a, :b, :c, :d)");
            if (!$stmt->execute([
                'newQuizId' => $newQuizInsertID,
                'question_id' =>  $newQuestionId,
                'number' => $question['number'],
                'newClassroomId' => $newClassroomId,
                'question_type' => $question['question_type'],
                'question_description' => $question['question_description'],
                'question_imagepath' => $question['question_imagepath'],
                'answer' => $question['answer'],
                'a' => $question['a'],
                'b' => $question['b'],
                'c' => $question['c'],
                'd' => $question['d']
            ])) {
                return "Failed to insert question: " . $question['question_description'];
            }
        }

        return true; // Return true if everything was successful
    }

    // // Example usage
    // $originalQuizId = 1; // ID of the quiz you want to copy
    // $newClassroomId = 2; // ID of the classroom where you want to copy the quiz
    // copyQuiz($originalQuizId, $newClassroomId);
    
}
?>
