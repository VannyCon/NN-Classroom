<?php 
    include_once('../../../controller/ClassroomController.php');

    // Display error messages if any
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
    }
    if (isset($_GET['classroom_id'])) {
        $classroom_id = $_GET['classroom_id'];
    }
    $reviews = $classroomService->getAllReviewsByClassroomID($classroom_id);
?>

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
            background-color: rgb(242, 175, 175);
            color: rgb(53, 53, 53);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="dashboard.php" class="btn btn-danger mb-3">Back</a>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>