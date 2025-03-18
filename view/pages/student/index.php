<?php 

  $expireDateTime = strtotime("2025-04-13 12:00:00"); // Change to your desired date & time
  $currentDateTime = time();
  if ($currentDateTime >= $expireDateTime) {
      die("Access to this service is no longer available. Please contact the administrator.");
  }

    include_once('../../../controller/LoginController.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:rgb(255, 255, 255);">
  <div class="container p-2">
  <section class="vh-100">
    <div class="container py-2 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-4 text-left">
              <div class="text-center">
                  <img src="../../../assets/images/logo.png" alt="" srcset="" width="auto" height="150">
              </div>
              <div class="text-center">
                <span class="badge text-bg-success p-4 py-2">Student</span>
              </div>
             
                  <form action="" method="post">
                      <div data-mdb-input-init class="form-outline mb-2">
                        
                      <?php if (isset($_GET['error'])): ?>
                          <p style="color: red;">Invalid username or password.</p>
                      <?php endif; ?>

                          <label class="form-label" for="typeEmailX-2">Username</label>
                              <input type="text" id="typeEmailX-2" name="username" class="form-control form-control-lg" required/>
                          </div>

                          <div data-mdb-input-init class="form-outline mb-4">
                          <label class="form-label" for="typePasswordX-2">Password</label>
                              <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" required/>
                          </div>
                          <input type="hidden" name="action" value="studentlogin">
                          <!-- Checkbox -->
                          <div class="form-check d-flex justify-content-start mb-4">
                          <input class="form-check-input bg-dark" type="checkbox" value="" id="form1Example3" />
                          <label class="form-check-label" for="form1Example3"> Remember password </label>
                          </div>

                          <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block w-100" type="submit">Login</button>
                          <div class="text-center mt-4">
                          <p>Don't have an account? <a href="register.php">Register</a></p>
                          </div>

                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php 
      include_once('view/components/footer.php');
  ?>
</body>
</html>

