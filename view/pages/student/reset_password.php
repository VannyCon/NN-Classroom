<?php
include_once('../../../controller/StudentController.php');


// Check if token is valid
if (!isset($_GET['token']) || !isset($_SESSION['reset_token']) || $_GET['token'] !== $_SESSION['reset_token']) {
    header("Location: forgot_password.php");
    exit;
}

// Get email from session
$email = $_SESSION['reset_email'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validate passwords
    if ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $messageType = "danger";
    } else {
        // Update password
        $result = $studentService->resetPassword($email, $password);
        
        if ($result === true) {
            // Password reset successful
            $message = "Password has been reset successfully.";
            $messageType = "success";
            
            // Clear session variables
            unset($_SESSION['reset_token']);
            unset($_SESSION['reset_email']);
            
            // Redirect to login after 3 seconds
            header("refresh:3;url=index.php");
        } else {
            // Error
            $message = "An error occurred. Please try again later.";
            $messageType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Sugarcane System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function togglePassword(id, iconId) {
      var passwordInput = document.getElementById(id);
      var eyeIcon = document.getElementById(iconId);
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    }
  </script>
</head>
<body>
  <div class="container p-2">
    <section class="vh-100">
      <div class="container py-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-4 text-left">
                <h3 class="text-center mb-4">Reset Password</h3>
                
                <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <form action="" method="post">
                  <div class="form-outline mb-3 position-relative">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                      <input type="password" id="password" name="password" class="form-control" required/>
                      <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', 'togglePassword1')">
                        <i id="togglePassword1" class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div class="form-outline mb-3 position-relative">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                      <input type="password" id="confirm_password" name="confirm_password" class="form-control" required/>
                      <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password', 'togglePassword2')">
                        <i id="togglePassword2" class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  
                  <button class="btn btn-primary w-100 mb-3" type="submit">Reset Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
</html>