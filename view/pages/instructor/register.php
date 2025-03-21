<?php 
    include_once('../../../controller/InstructorController.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
<body style="background-color:rgb(255, 255, 255);">
<div class="container p-2">
    <section class="vh-100">
        <div class="container py-2 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-left">
                            <div class="text-center">
                                <img src="../../../assets/images/logo.png" alt="Logo" height="150">
                            </div>
                            <div class="text-center">
                                <span class="badge text-bg-warning p-4 py-2">Instructor Registration</span>
                            </div>

                            <!-- Registration Form -->
                            <form action="" method="post">
                                <?php if (isset($_GET['error'])): ?>
                                    <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                                <?php endif; ?>

                                <!-- Full Name -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="fullname">Full Name</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control form-control-lg" required />
                                </div>
                                
                                 <!-- email -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                </div>

                                <!-- Username -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                                </div>

                                <!-- Password -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', 'togglePassword1')">
                                            <i id="togglePassword1" class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="action" value="registerInstructor">

                                <!-- Register Button -->
                                <button class="btn btn-dark btn-lg btn-block w-100" type="submit">Register</button>

                                <div class="text-center mt-4">
                                    <p>Already have an account? <a href="index.php">Login</a></p>
                                </div>
                            </form>
                            <!-- End Registration Form -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
</div>
</body>
</html>
