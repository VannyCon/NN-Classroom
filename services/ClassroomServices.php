<?php
require_once("../../../../connection/config.php");
require_once("../../../../connection/connection.php");

class TriviaServices extends config {
    public function getAllTrivia() {
        try {
                $query = "SELECT * FROM `tbl_trivia` ";
                $stmt = $this->pdo->prepare($query); // Prepare the query
                $stmt->execute(); // Execute the query
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function create($trivia_id, $title, $body, $imagePaths) {
        try {
            $query = "INSERT INTO `tbl_trivia` (`trivia_id`, `title`, `body`, `image_path`) VALUES (:trivia_id, :title, :body, :image_path)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':trivia_id', $trivia_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':image_path', $imagePaths);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }    
    public function getTriviaInfoId($id) {
        try {
                $query = "SELECT `id`, `trivia_id`, `title`, `body`, `image_path`, `created_date` FROM `tbl_trivia` WHERE id =  :id";
                $stmt = $this->pdo->prepare($query); // Prepare the query
                $stmt->bindParam(':id', $id); // Bind the value
                $stmt->execute(); // Execute the query
                return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function update($id, $title, $body) {
        try {
            // Define the query with placeholders for updating an existing record
            $query = "UPDATE `tbl_trivia` 
                        SET `title` = :title,
                            `body` = :body
                        WHERE `id` = :id";
     
            // Prepare the query
            $stmt = $this->pdo->prepare($query);
            // Bind the values to the placeholders
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // Explicitly specify type for $id
     
            // Execute the query
            $stmt->execute();
            return true; // Returns true if at least one row was affected
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false if the operation fails
        }
    }
    public function delete($id) {
        try {
            $query = "DELETE FROM `tbl_trivia` WHERE `id` = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Check if the deletion was successful
            return $stmt->rowCount() > 0; // Return true if at least one row was deleted
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
