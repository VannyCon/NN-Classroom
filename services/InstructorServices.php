<?php 
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class InstructorServices extends config {
    public function registerInstructor($fullname, $username, $password, $instructor_id) {
        try {
            // Insert query
            $query = "INSERT INTO `tbl_instructor` (instructor_id, instructor_username, instructor_password, instructor_fullname, isApproved) 
                    VALUES (:instructor_id, :username, :password, :fullname, 0)";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fullname', $fullname);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function instructorLogout() {
        session_start(); // Ensure session is started
    
        // Unset only instructor-related session variables
        unset($_SESSION['instructor_id']);
        unset($_SESSION['instructor_username']);
        unset($_SESSION['instructor_fullname']);
    
        // Check if all instructor-related session variables are removed
        if (!isset($_SESSION['instructor_id']) && 
            !isset($_SESSION['instructor_username']) && 
            !isset($_SESSION['instructor_fullname'])) {
            
            // Destroy session only if no instructor data remains
            session_write_close(); // Ensures session is saved before redirecting
            header("Location: index.php"); // Redirect to index.php
            exit();
        }
    }
    
    
}
?>