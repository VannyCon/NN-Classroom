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

}
?>
