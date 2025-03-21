<?php
require_once("../../../middleware/Middleware.php");

class Dashboard extends config {

    public function getBenefits() {
        try {
            $query = "SELECT `id`, `title`, `body`, `created_date`, `image_path` FROM `tbl_benefits` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function getDisease() {
        try {
            $query = "SELECT `id`, `title`, `information`, `solution`, `created_date`, `image_path` FROM `tbl_disease` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function getTrivia() {
        try {
            $query = "SELECT `id`, `title`, `body`, `created_date`, `image_path` FROM `tbl_trivia` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    

}




?>
