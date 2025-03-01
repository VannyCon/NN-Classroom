<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class StudentServices extends config {

    public function registerStudent($student_id, $username, $password, $fullname) {
        try {
            // Debug: Check connection
            if (!$this->pdo) {
                error_log("Database connection failed");
                return false;
            }

            // Check if username already exists
            $checkQuery = "SELECT COUNT(*) FROM tbl_student WHERE student_username = :username";
            $checkStmt = $this->pdo->prepare($checkQuery);
            $checkStmt->bindParam(':username', $username);
            $checkStmt->execute();
            
            if ($checkStmt->fetchColumn() > 0) {
                error_log("Username already exists: $username");
                return false;
            }

            // Insert query
            $query = "INSERT INTO `tbl_student` (student_id, student_username, student_password, student_fullname) 
                      VALUES (:student_id, :username, :password, :fullname)";
            
            // Debug: Log the query
            error_log("Executing query: " . $query);
            error_log("With values - ID: $student_id, Username: $username, Fullname: $fullname");

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fullname', $fullname);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Execute failed: " . print_r($stmt->errorInfo(), true));
                return false;
            }
            
            return true;

        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }


    public function enrollClassroom($student_id, $code) {
        try {
            // Check if classroom exists
            $checkQuery = "SELECT `id`, `classroom_id`, `instructor_id_fk` 
                           FROM `tbl_classroom` 
                           WHERE `code` = :code AND `isActive` = 1";
            $checkStmt = $this->pdo->prepare($checkQuery);
            $checkStmt->bindParam(':code', $code);
            $checkStmt->execute();
            $classroom = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$classroom) {
                return ['success' => false, 'message' => "Classroom not found."];
            }
    
            $classroomID = $classroom['classroom_id'];
            $instructorID = $classroom['instructor_id_fk'];
    
            // Check if student already enrolled
            $checkStudentQuery = "SELECT `approved` FROM `tbl_classroom_student` 
                                  WHERE `classroom_id_fk` = :classroomID 
                                  AND `student_id_fk` = :student_id";
            $checkStudentStmt = $this->pdo->prepare($checkStudentQuery);
            $checkStudentStmt->bindParam(':classroomID', $classroomID);
            $checkStudentStmt->bindParam(':student_id', $student_id);
            $checkStudentStmt->execute();
            $existingEnrollment = $checkStudentStmt->fetch(PDO::FETCH_ASSOC);
    
            if ($existingEnrollment) {
                if ($existingEnrollment['approved'] == 2) {
                    return ['success' => false, 'message' => "You were rejected from this classroom."];
                }
                return ['success' => false, 'message' => "You have already enrolled in this classroom."];
            }
    
            // Enroll student
            $query = "INSERT INTO `tbl_classroom_student` (`classroom_id_fk`, `student_id_fk`, `instructor_id_fk`) 
                      VALUES (:classroomID, :student_id, :instructorID)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':classroomID', $classroomID);
            $stmt->bindParam(':instructorID', $instructorID);
            $result = $stmt->execute();
    
            return $result ? ['success' => true] : ['success' => false, 'message' => "Failed to enroll."];
    
        } catch (PDOException $e) {
            return ['success' => false, 'message' => "Enrollment error: " . $e->getMessage()];
        }
    }
    
    
    public function showStudentClassroom($student_id) {
        try {
            // Select query to get classrooms for a specific instructor
            $query = "SELECT 
                    cs.id AS enrollment_id,
                    cs.student_id_fk,
                    cs.instructor_id_fk,
                    cs.approved,
                    c.classroom_id,
                    c.classroom_title,
                    c.classroom_description,
                    c.isActive,
                    c.code,
                    c.created_date
                FROM tbl_classroom_student cs
                JOIN tbl_classroom c ON cs.classroom_id_fk = c.classroom_id
                WHERE cs.student_id_fk = :student_id AND  c.isActive = 1 AND  cs.approved != 2;
                ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id); // Ensure proper type
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Log error instead of echoing
            return false;   
        }
    }

    public function studentLogout() {
        session_start(); // Ensure session is started
    
        // Unset only instructor-related session variables
        unset($_SESSION['student_id']);
        unset($_SESSION['student_username']);
        unset($_SESSION['student_fullname']);
    
        // Check if all instructor-related session variables are removed
        if (!isset($_SESSION['student_id']) && 
            !isset($_SESSION['student_username']) && 
            !isset($_SESSION['student_fullname'])) {
            
            // Destroy session only if no instructor data remains
            session_write_close(); // Ensures session is saved before redirecting
            header("Location: index.php"); // Redirect to index.php
            exit();
        }
    }


}
?>
