<?php
    include_once('../../../controller/StudentController.php');
    $successMessage = isset($_GET['success']) ? $_GET['success'] : '';
    $studentId = $_SESSION['student_id'] ?? null;
    $classroomList = $studentService->showStudentClassroom($studentId);
?>
<!-- student.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
        .grayscale {
            filter: grayscale(100%);
            opacity: 0.6;
        }
    </style>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">Student Dashboard</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Student Dashboard</h2>
        <p class="text-center">View courses, submit assignments, and track progress.</p>

        <!-- Enrollment Card -->
        <div class="card shadow-lg p-4">
            <div class="card-body text-center">
                <h4 class="card-title">Enroll in a Classroom</h4>
                <p class="card-text">Enter the classroom code provided by your instructor.</p>
                <form action="" method="POST" class="mt-3">
                    <input type="hidden" name="action" value="enrollClassroom">
                    <div class="input-group mb-3">
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Classroom Code" required>
                        <button type="submit" class="btn btn-primary">Enroll</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="text-center mb-4">Your Enrolled Classrooms</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (!empty($classroomList)): ?>
                    <?php foreach ($classroomList as $classroom): ?>
                        <div class="col">
                            <div class="card h-100 shadow-lg border-0 <?php echo ($classroom['approved'] == 0) ? 'grayscale' : ''; ?>">
                                <div class="card-header bg-primary text-white text-center py-3 position-relative">
                                    <h5 class="card-title m-0"><?php echo htmlspecialchars($classroom['classroom_title']); ?></h5>
                                    <?php if ($classroom['approved'] == 0): ?>
                                        <span class="badge bg-warning position-absolute top-0 start-50 translate-middle"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Waiting for instructor approval. Please check back later.">
                                            ⏳ Pending Approval
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">
                                        <?php echo nl2br(htmlspecialchars($classroom['classroom_description'])); ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-light text-center">
                                    <?php if ($classroom['approved'] == 1): ?>
                                        <a href="classroom.php?classroom_id=<?php echo $classroom['classroom_id']; ?>" class="btn btn-outline-primary">View Classroom</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Your enrollment is pending approval by the instructor.">
                                            Pending Approval
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">You are not enrolled in any classrooms yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <!-- Enrollment Modal -->
    <div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="enrollmentModalLabel">Enrollment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const errorMessage = urlParams.get('error');

            if (errorMessage) {
                document.getElementById("modalMessage").textContent = errorMessage;
                let enrollmentModal = new bootstrap.Modal(document.getElementById("enrollmentModal"));
                enrollmentModal.show();
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
