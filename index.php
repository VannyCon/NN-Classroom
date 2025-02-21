<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center center-container">
        <div class="text-center">
            <h2>Select Your Role</h2>
            <div class="mt-3">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <a href="view/pages/admin/index.php" class="btn btn-danger w-100">Admin</a>
                    </div>
                </div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <a href="view/pages/instructor/index.php" class="btn btn-warning w-100">Instructor</a>
                    </div>
                </div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <a href="view/pages/student/index.php" class="btn btn-success w-100">Student</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>