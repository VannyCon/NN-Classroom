<?php
require_once("../../../middleware/Middleware.php");

class ClassroomServices extends config {
    public function createClassroom($classroomId, $classroomTitle, $classroomDescription, $instructorId, $randomCode) {
        try {
            $query = "INSERT INTO `tbl_classroom` (`classroom_id`, `classroom_title`, `classroom_description`, `instructor_id_fk`, `isActive`, `code`, `created_date`) 
                      VALUES (:classroom_id, :classroom_title, :classroom_description, :instructor_id, 1, :code, NOW())";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':classroom_id', $classroomId);
            $stmt->bindParam(':classroom_title', $classroomTitle);
            $stmt->bindParam(':classroom_description', $classroomDescription);
            $stmt->bindParam(':instructor_id', $instructorId);
            $stmt->bindParam(':code', $randomCode);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateClassroom($id, $classroomTitle, $classroomDescription, $classroomStatus) {
        try {
            $query = "UPDATE `tbl_classroom` SET `classroom_title`=:classroom_title,`classroom_description`=:classroom_description,`isActive`=:isActive WHERE `id`=:id";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':classroom_title', $classroomTitle);
            $stmt->bindParam(':classroom_description', $classroomDescription);
            $stmt->bindParam(':isActive', $classroomStatus);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function showInstructorClassroom($instructor_id) {
        try {
            // Select query to get classrooms for a specific instructor
            $query = "SELECT * FROM `tbl_classroom` WHERE `instructor_id_fk` = :instructor_id AND `isActive` = 1";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id); // Ensure proper type
            $stmt->execute(); // Execute the query
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Log error instead of echoing
            return false;
        }
    }

    public function showStudentInClassroom($instructor_id, $classroom_id) {
        try {
            // Select query to get classrooms for a specific instructor
            $query = "SELECT 
                            cs.id AS enrollment_id,
                            cs.classroom_id_fk,
                            cs.student_id_fk,
                            cs.instructor_id_fk,
                            cs.approved,
                            s.student_id,
                            s.student_fullname
                        FROM tbl_classroom_student cs
                        JOIN tbl_student s ON cs.student_id_fk = s.student_id
                        WHERE cs.classroom_id_fk = :classroom_id AND  cs.instructor_id_fk = :instructor_id";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id); // Ensure proper type
            $stmt->bindParam(':classroom_id', $classroom_id); // Ensure proper type
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Log error instead of echoing
            return false;   
        }
    }
    

    public function updateStudentStatus($studentId, $status) {
        try {
            $query = "UPDATE tbl_classroom_student SET approved = :status WHERE id = :student_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating student status: " . $e->getMessage());
            return false;
        }
    }
    

    public function createReview($reviwerID, $reviewerTitle, $reviewerDescription, $docsPath, $instructorId, $classroomId) {
        try {
            $query = "INSERT INTO `tbl_reviewer` (`reviewer_id`, `reviewer_title`, `reviewer_description`, `docs_path`, `instructor_id_fk`, `classroom_id_fk`, `isActive`, `created_date`) 
                      VALUES (:reviewer_id, :reviewer_title, :reviewer_description, :docs_path, :instructor_id, :classroom_id, 1, NOW())";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':reviewer_id', $reviwerID);
            $stmt->bindParam(':reviewer_title', $reviewerTitle);
            $stmt->bindParam(':reviewer_description', $reviewerDescription);
            $stmt->bindParam(':docs_path', $docsPath);
            $stmt->bindParam(':instructor_id', $instructorId);
            $stmt->bindParam(':classroom_id', $classroomId);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateReview($reviewerID, $reviewerTitle, $reviewerDescription, $docsPath) {
        try {
            // If no new document is uploaded, only update title and description
            if ($docsPath === null) {
                $query = "UPDATE `tbl_reviewer` SET `reviewer_title`= :reviewer_title, `reviewer_description`= :reviewer_description WHERE reviewer_id = :reviewer_id";
                
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':reviewer_id', $reviewerID); // Fixed typo here
                $stmt->bindParam(':reviewer_title', $reviewerTitle);
                $stmt->bindParam(':reviewer_description', $reviewerDescription);
            } else {
                // If a new document is uploaded, update all fields
                $query = "UPDATE `tbl_reviewer` SET `reviewer_title`= :reviewer_title, `reviewer_description`= :reviewer_description, `docs_path`= :docs_path WHERE reviewer_id = :reviewer_id";
                
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':reviewer_id', $reviewerID); // Fixed typo here
                $stmt->bindParam(':reviewer_title', $reviewerTitle);
                $stmt->bindParam(':reviewer_description', $reviewerDescription);
                $stmt->bindParam(':docs_path', $docsPath);
            }
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getAllReviews() {
        try {
            $query = "SELECT * FROM `tbl_reviewer` WHERE `isActive` = 1 ORDER BY `created_date` DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllReviewsByClassroomID($classroom_id) {
        try {
            $query = "SELECT * FROM `tbl_reviewer` WHERE `isActive` = 1 AND `classroom_id_fk` = :classroom_id ORDER BY `created_date` DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':classroom_id', $classroom_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteReview($id) {
        try {
            $query = "DELETE FROM `tbl_reviewer` WHERE `id` = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
