<?php 
    include_once('../../../middleware/InstructorMiddleware.php');
    $successMessage = $_GET['success'] ?? '';
    $instructorId = $_SESSION['instructor_id'] ?? null;
    $classroomId = $_GET['classroom_id'] ?? null; 
    if (!$instructorId || !$classroomId) {
        header("Location: classroom.php?error=Instructor not logged in or Classroom doesn't exist.");
        exit();
    }
    $quizzes = $quizService->getInsQuizzes($classroomId);
?>

<!-- View -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <style>
        body {
            background-color: #f1f3f4;
        }
        .quiz-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .quiz-card:hover {
            transform: translateY(-5px);
        }
        .quiz-title {
            font-size: 20px;
            font-weight: bold;
            color: #3c4043;
        }
        .quiz-description {
            color: #5f6368;
        }
        .quiz-meta {
            font-size: 12px;
            color: gray;
        }
        .expired {
            background-color: #e0e0e0;
            color: #9e9e9e;
            pointer-events: none;
            filter: grayscale(100%);
            border: 2px solid #9e9e9e;
        }
        .expired .quiz-title {
            text-decoration: line-through;
        }
        .expire {
            background-color:rgb(242, 175, 175);
            color:rgb(53, 53, 53);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-danger mb-3">Back</a>
        <a href="classroom_student.php?classroom_id=<?php echo $_GET['classroom_id']; ?>" class="btn btn-info mb-3">
            Manage Student
        </a>

        
         <!-- Bootstrap Tab Navigation (Required for data-bs-toggle="tab") -->
         <ul class="nav nav-tabs justify-content-center border-bottom flex-nowrap overflow-auto" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="section1-tab" data-bs-toggle="tab" data-bs-target="#section1" type="button" role="tab"><i class="fas fa-question"></i> Quizes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="section2-tab" data-bs-toggle="tab" data-bs-target="#section2" type="button" role="tab"><i class="fas fa-book"></i> Reviewers</button>
            </li>
        </ul>

         <!-- Tab Content -->
         <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="section1" role="tabpanel">
                <?php include_once('quizes.php'); ?>
            </div>
            <div class="tab-pane fade" id="section2" role="tabpanel">
                <?php include_once('reviewer.php'); ?>
            </div>
        </div>
        


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
