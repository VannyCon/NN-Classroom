<?php
include_once('../../../controller/StudentController.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['otp'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    
    $result = $studentService->verifyOTP($email, $otp);
    
    if ($result === true) {
        // OTP is valid
        // Generate a temporary token for password reset
        $token = bin2hex(random_bytes(32));
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_email'] = $email;
        
        // Redirect to reset password page
        header("Location: reset_password.php?token=$token");
        exit;
    } else {
        // Invalid OTP
        $message = "Invalid or expired OTP. Please try again.";
        $messageType = "danger";
    }
}

// Check if email is provided in the URL
if (!isset($_GET['email'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP - Sugarcane System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container p-2">
    <section class="vh-100">
      <div class="container py-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-4 text-left">
                <h3 class="text-center mb-4">Verify OTP</h3>
                
                <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <div class="alert alert-info">
                  An OTP has been sent to your email. Please enter it below to reset your password.
                  The OTP will expire in 5 minutes.
                </div>
                
                <form action="" method="post">
                  <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                  
                  <div class="form-outline mb-3">
                    <label class="form-label">OTP Code</label>
                    <input type="text" name="otp" class="form-control" required placeholder="Enter OTP code" />
                  </div>
                  
                  <button class="btn btn-primary w-100 mb-3" type="submit">Verify OTP</button>
                  
                  <div class="text-center">
                    <p><a href="forgot_password.php">Request new OTP</a></p>
                  </div>
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