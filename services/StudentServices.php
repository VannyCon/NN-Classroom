<?php
require_once("../../../middleware/Middleware.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require '../../../vendor/autoload.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php'; // Adjust based on your structure
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
class StudentServices extends config {

    public function registerStudent($student_id, $username, $password, $fullname, $email) {
        try {
            // Debug: Check connection
            if (!$this->pdo) {
                error_log("Database connection failed");
                return false;
            }

            if ($this->checkEmailExists($email)) {
                return "Email already exists.";
            }

            // Check if username is unique
            if (!$this->checkUniqueUsername($username)) {
                return "Username already exists.";
            }

            // Insert query
            $query = "INSERT INTO `tbl_student` (student_id, student_username, student_password, student_fullname, email) 
                      VALUES (:student_id, :username, :password, :fullname, :email)";
            
            // Debug: Log the query
            error_log("Executing query: " . $query);
            error_log("With values - ID: $student_id, Username: $username, Fullname: $fullname");

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':email', $email);
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

    public function checkEmailExists($email) {
        try {
            $query = "SELECT COUNT(*) FROM tbl_student WHERE email = :email";
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
            $query = "SELECT COUNT(*) FROM tbl_student WHERE student_username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn() == 0; // Returns true if username is unique, false if it exists
        } catch (PDOException $e) {
            error_log("Username check error: " . $e->getMessage());
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

    
    public function checkUniqueEmail($email) {
        try {
            // Prepare and execute query to check if email exists
            $query = "SELECT COUNT(*) FROM tbl_student WHERE email = :email";
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
            $updateQuery = "UPDATE tbl_student SET otp_code = :otp, otp_expiration = :expiration WHERE email = :email";
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
            $query = "SELECT id FROM tbl_student WHERE email = :email AND otp_code = :otp AND otp_expiration > :currentTime";
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
            $query = "UPDATE tbl_student SET student_password = :password, otp_code = NULL, otp_expiration = NULL WHERE email = :email";
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


    public function changePassword($student_id, $oldPass, $newPass) {
        try {
            // Retrieve the current password hash
            $query = "SELECT student_password FROM `tbl_student` WHERE student_id = :student_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();
            $storedHash = $stmt->fetchColumn();
    
            // Check if the old password matches
            if (!$storedHash || !password_verify($oldPass, $storedHash)) {
                return "Wrong old password.";
            }
    
            // Hash the new password before updating
            $hashedNewPass = password_hash($newPass, PASSWORD_BCRYPT);
    
            // Update query
            $query = "UPDATE `tbl_student` SET `student_password` = :student_password WHERE `student_id` = :student_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':student_password', $hashedNewPass);
    
            return $stmt->execute() ? true : "Password update failed.";
        } catch (PDOException $e) {
            error_log("Password change error: " . $e->getMessage());
            return false;
        }
    }
    

}
?>
