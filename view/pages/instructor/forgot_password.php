<?php
include_once('../../../controller/InstructorController.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // First check if email exists before sending OTP
    $emailExists = $instructor->checkEmailExists($email);
    
    if ($emailExists) {
        // Email exists, generate and send OTP
        $result = $instructor->initiatePasswordReset($email);
        
        if ($result === true) {
            // Success - redirect to OTP verification page
            header("Location: verify_otp.php?email=" . urlencode($email));
            exit;
        } else {
            // Error sending OTP
            $message = "An error occurred while sending OTP. Please try again later.";
            $messageType = "danger";
        }
    } else {
        // Email doesn't exist
        $message = "Email not found in our records.";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Sugarcane System</title>
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
                <h3 class="text-center mb-4">Forgot Password</h3>
                
                <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <form action="" method="post">
                  <div class="form-outline mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your registered email" />
                  </div>
                  
                  <button class="btn btn-primary w-100 mb-3" type="submit">Send OTP</button>
                  
                  <div class="text-center">
                    <p>Remember your password? <a href="index.php">Back to Login</a></p>
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