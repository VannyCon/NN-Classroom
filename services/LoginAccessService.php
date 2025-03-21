<?php 

require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class LoginAccess extends config {
    public function adminlogin($username, $password){
        try {
            // Prepare and execute query to get user by username
            $query = "SELECT * FROM tbl_admin WHERE admin_username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin && $password === $admin['admin_password']) {
                // Password is correct, start a session
                $_SESSION['admin_id'] =  $admin['id'];
                $_SESSION['admin_username'] = $admin['admin_username'];
                // Redirect to a protected page
                return true;
                exit();
            } else {
                $error = "Invalid username or password.";
                return false;
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
            return false;
        }
    }

    public function instructorlogin($username, $password) {
        try {
            // Prepare and execute query to get user by username
            $query = "SELECT * FROM tbl_instructor WHERE instructor_username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if user exists and verify password
            if ($user && password_verify($password, $user['instructor_password'])) {
                // Start a session and store user data
                $_SESSION['instructor_id'] = $user['instructor_id'];
                $_SESSION['instructor_username'] = $user['instructor_username'];
                $_SESSION['instructor_fullname'] = $user['instructor_fullname'];
                return [
                    'success' => true,
                    'status' => $user['isApproved'] ?? null // Assuming 'isApproved' is the status column
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Invalid username or password.'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => 'System Error.'
            ];
        }
    }
    

    public function studentlogin($student_username, $password){
        try {
            // Prepare and execute query to get user by username
            $query = "SELECT * FROM tbl_student WHERE student_username = :student_username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_username', $student_username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['student_password'])) {
                // Password is correct, start a session
                $_SESSION['student_id'] =  $user['student_id'];
                $_SESSION['student_username'] = $user['student_username'];
                $_SESSION['student_fullname'] = $user['student_fullname'];
                // Redirect to a protected page
                return true;
                exit();
            } else {
                $error = "Invalid username or password.";
                return false;
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
            return false;
        }
    }
    


}
?>