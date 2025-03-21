<?php 
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require '../../../vendor/autoload.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php'; // Adjust based on your structure
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
class InstructorServices extends config {

    public function registerInstructor($fullname, $username, $password, $email, $instructor_id) {
        try {
            // Check if email is unique
            if ($this->checkEmailExists($email)) {
                return "Email already exists.";
            }

            // Check if username is unique
            if (!$this->checkUniqueUsername($username)) {
                return "Username already exists.";
            }
            // Insert query
            $query = "INSERT INTO `tbl_instructor` (instructor_id, instructor_username, instructor_password, instructor_fullname, email, isApproved) 
                    VALUES (:instructor_id, :username, :password, :fullname, :email, 0)";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            if ($stmt->execute()) {
                return true; // Registration successful
            } else {
                return "Registration failed due to a database error.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function checkEmailExists($email) {
        try {
            $query = "SELECT COUNT(*) FROM tbl_instructor WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Email check error: " . $e->getMessage());
            return false;
        }
    }
    
    public function checkUniqueUsername($username) {
        try {
            $query = "SELECT COUNT(*) FROM tbl_instructor WHERE instructor_username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn() == 0; // Returns true if username is unique, false if it exists
        } catch (PDOException $e) {
            error_log("Username check error: " . $e->getMessage());
            return false;
        }
    }

    public function instructorLogout() {
    
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
    
    public function checkUniqueEmail($email) {
        try {
            // Prepare and execute query to check if email exists
            $query = "SELECT COUNT(*) FROM tbl_instructor WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            return $count > 0; // Returns true if email is unique, false if it exists
        } catch (PDOException $e) {
            return false; // Handle error
        }
    }
    
    public function initiatePasswordReset($email) {
        try {
            // Generate OTP
            $otp = mt_rand(100000, 999999); // 6-digit OTP
            
            // Set expiration time (5 minutes from now)
            $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            
            // Update user record with OTP and expiration
            $updateQuery = "UPDATE tbl_instructor SET otp_code = :otp, otp_expiration = :expiration WHERE email = :email";
            $updateStmt = $this->pdo->prepare($updateQuery);
            $updateStmt->bindParam(':otp', $otp);
            $updateStmt->bindParam(':expiration', $expiration);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();
            
            if ($updateStmt->rowCount() > 0) {
                // Send OTP via email
                $this->sendOTPEmail($email, $otp);
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Password reset error: " . $e->getMessage());
            return false;
        }
    }
    public function verifyOTP($email, $otp) {
        try {
            $currentTime = date('Y-m-d H:i:s');
            
            // Check if OTP is valid and not expired
            $query = "SELECT id FROM tbl_instructor WHERE email = :email AND otp_code = :otp AND otp_expiration > :currentTime";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':otp', $otp);
            $stmt->bindParam(':currentTime', $currentTime);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("OTP verification error: " . $e->getMessage());
            return false;
        }
    }
    
    public function resetPassword($email, $password) {
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Update user password
            $query = "UPDATE tbl_instructor SET instructor_password = :password, otp_code = NULL, otp_expiration = NULL WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Password reset error: " . $e->getMessage());
            return false;
        }
    }


    private function sendOTPEmail($email, $otp) {
        // Use PHPMailer for more reliable email sending
        require '../../../vendor/autoload.php';
        
        $mail = new PHPMailer(true);
        
        try {
            // Gmail SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'vannycon001@gmail.com';
            $mail->Password   = 'cjrryybbsdnozeoz'; // Use app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            
            // Recipients
            $mail->setFrom('vannycon001@gmail.com', 'HardwareCore System');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = '
                <html>
                <body>
                    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                        <div style="background-color: #f8f9fa; padding: 20px; text-align: center;">
                            <h2>Password Reset</h2>
                        </div>
                        <div style="padding: 20px;">
                            <p>Your OTP for password reset is:</p>
                            <div style="font-size: 24px; font-weight: bold; text-align: center; padding: 10px; background-color: #f0f0f0; margin: 20px 0;">
                                ' . $otp . '
                            </div>
                            <p>This code will expire in 5 minutes.</p>
                            <p>If you did not request this password reset, please ignore this email.</p>
                        </div>
                        <div style="background-color: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; color: #6c757d;">
                            &copy; ' . date('Y') . ' Sugarcane System. All rights reserved.
                        </div>
                    </div>
                </body>
                </html>
            ';
            $mail->AltBody = "Your OTP for password reset is: $otp\n\nThis code will expire in 5 minutes.\n\nIf you did not request this password reset, please ignore this email.";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function changePassword($instructor_id, $oldPass, $newPass) {
        try {
            // Retrieve the current password hash
            $query = "SELECT instructor_password FROM `tbl_instructor` WHERE instructor_id = :instructor_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id);
            $stmt->execute();
            $storedHash = $stmt->fetchColumn();
    
            // Check if the old password matches
            if (!$storedHash || !password_verify($oldPass, $storedHash)) {
                return "Wrong old password.";
            }
    
            // Hash the new password before updating
            $hashedNewPass = password_hash($newPass, PASSWORD_BCRYPT);
    
            // Update query
            $query = "UPDATE `tbl_instructor` SET `instructor_password` = :instructor_password WHERE `instructor_id` = :instructor_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id);
            $stmt->bindParam(':instructor_password', $hashedNewPass);
    
            return $stmt->execute() ? true : "Password update failed.";
        } catch (PDOException $e) {
            error_log("Password change error: " . $e->getMessage());
            return false;
        }
    }
}
?>