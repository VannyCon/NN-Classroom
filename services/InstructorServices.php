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
}
?>