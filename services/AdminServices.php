<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class AdminServices extends config {
    public function getAllInstructor() {
        try {
                $query = "SELECT * FROM `tbl_instructor` ";
                $stmt = $this->pdo->prepare($query); // Prepare the query
                $stmt->execute(); // Execute the query
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAllNeedApprovalInstructor() {
        try {
                $query = "SELECT * FROM `tbl_instructor` WHERE isApproved = 0";
                $stmt = $this->pdo->prepare($query); // Prepare the query
                $stmt->execute(); // Execute the query
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getSpecificIntructorById($id) {
        try {
                $query = "SELECT * FROM `tbl_instructor` WHERE id =  :id";
                $stmt = $this->pdo->prepare($query); // Prepare the query
                $stmt->bindParam(':id', $id); // Bind the value
                $stmt->execute(); // Execute the query
                return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
   
    
    public function updateStatus($instructor_id, $status) {
        try {
            // Define the query with placeholders for updating an existing record
            $query = "UPDATE `tbl_instructor` 
                        SET `isApproved` = :isApproved
                        WHERE `instructor_id` = :instructor_id";
     
            // Prepare the query
            $stmt = $this->pdo->prepare($query);
            // Bind the values to the placeholders
            $stmt->bindParam(':isApproved', $status);
            $stmt->bindParam(':instructor_id', $instructor_id);  // Explicitly specify type for $id
            // Execute the query
            $stmt->execute();
            return true; // Returns true if at least one row was affected
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false if the operation fails
        }
    }

    public function adminLogout() {
    
        // Unset only admin-related session variables
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
    
        // Check if all admin-related session variables are removed
        if (!isset($_SESSION['admin_id']) && 
            !isset($_SESSION['admin_username'])) {
            
            // Destroy session only if no admin data remains
            session_write_close(); // Ensures session is saved before redirecting
            header("Location: index.php"); // Redirect to index.php
            exit();
        }
    }
    
  
}
?>
