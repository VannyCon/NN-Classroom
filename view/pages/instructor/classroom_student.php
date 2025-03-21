<?php 
    include_once('../../../middleware/InstructorMiddleware.php');
    $successMessage = $_GET['success'] ?? '';
    $instructorId = $_SESSION['instructor_id'] ?? null;
    $classroomId = $_GET['classroom_id'] ?? null; 
    if (!$instructorId || !$classroomId) {
        header("Location: classroom.php?error=Instructor not logged in or Classroom doesn't exist.");
        exit();
    }

    $studentList = $classroomService->showStudentInClassroom($instructorId, $classroomId);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f1f3f4;
        }
        .student-list {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .student-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .student-name {
            font-size: 16px;
            font-weight: 500;
        }
        .pending {
            color: gray;
            opacity: 0.6;
            cursor: not-allowed;
        }
        .tooltip-custom {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip-custom .tooltip-text {
            visibility: hidden;
            width: 180px;
            background-color: black;
            color: white;
            text-align: center;
            padding: 5px;
            border-radius: 4px;
            position: absolute;
            z-index: 1;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip-custom:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <a href="classroom.php?classroom_id=<?php echo $classroomId?>" class="btn btn-danger mb-3">Back</a>
        <h2>Classroom Students</h2>

        <div class="student-list mt-3">
    <?php if (!empty($studentList)) : ?>
        <?php foreach ($studentList as $student) : ?>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="student-row <?php echo ($student['approved'] == 0) ? 'pending' : ''; ?>">
                    <span class="student-name">
                        <?php echo htmlspecialchars($student['student_fullname']); ?>
                    </span>
                </div>

                <div class="actions">
                    <?php if ($student['approved'] == 0) : ?>
                        <div class="tooltip-custom">
                            <i class="fas fa-hourglass-half text-warning"></i>
                            <span class="tooltip-text">Pending approval</span>
                        </div>
                        <button class="btn btn-success btn-sm approve-btn" data-id="<?php echo $student['enrollment_id']; ?>">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="btn btn-danger btn-sm reject-btn" data-id="<?php echo $student['enrollment_id']; ?>">
                            <i class="fas fa-times"></i> Reject
                        </button>

                    <?php elseif ($student['approved'] == 1) : ?>
                        <span class="text-success"><i class="fas fa-check-circle"></i> Approved</span>

                    <?php elseif ($student['approved'] == 2) : ?>
                        <span class="text-danger"><i class="fas fa-times-circle mx-2"></i> Rejected</span>
                        <button class="btn btn-success btn-sm approve-btn " data-id="<?php echo $student['enrollment_id']; ?>">
                            <i class="fas fa-check"></i> Approve
                        </button>

                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No students enrolled in this classroom.</p>
    <?php endif; ?>
</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".approve-btn").forEach(button => {
            button.addEventListener("click", function () {
                let studentId = this.getAttribute("data-id");
                updateStudentStatus(studentId, 1); // Approve
            });
        });

        document.querySelectorAll(".reject-btn").forEach(button => {
            button.addEventListener("click", function () {
                let studentId = this.getAttribute("data-id");
                updateStudentStatus(studentId, 2); // Reject
            });
        });

        function updateStudentStatus(studentId, status) {
            fetch("classroom_student.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `student_id=${studentId}&status=${status}&action=updateStudentStatus`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh to show updated status
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
</script>

</body>
</html>
