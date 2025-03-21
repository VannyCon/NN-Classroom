<?php
    include_once('../../../middleware/InstructorMiddleware.php');

$classroomID = $_GET['classroom_id'] ?? null;

// Redirect to classroom.php after 5 seconds
echo "<script>
    setTimeout(function() {
        window.location.href = 'classroom.php?classroom_id=$classroomID';
    }, 5000);
</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f1f3f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .result-card {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .result-icon {
            font-size: 50px;
            color: #34a853;
        }
        .score {
            font-size: 36px;
            font-weight: bold;
            color: #202124;
        }
        .total {
            font-size: 20px;
            color: #5f6368;
        }
        .countdown {
            font-size: 18px;
            color: #d93025;
            font-weight: bold;
            margin-top: 10px;
        }
        .back-btn {
            margin-top: 20px;
            display: inline-block;
            background-color: #4285F4;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #357ae8;
        }
    </style>
</head>
<body>

<div class="result-card">
    <i class="fa-solid fa-check result-icon"></i>
    <h2 class="mt-3">Successfull Created!</h2>
    <p class="countdown" id="countdown">Redirecting in 5 seconds...</p>
    <a href="classroom.php?classroom_id=<?= htmlspecialchars($classroomID) ?>" class="back-btn">Go Back to Classroom</a>
</div>

<script>
    let seconds = 5;
    const countdownElement = document.getElementById('countdown');
    setInterval(() => {
        seconds--;
        countdownElement.textContent = "Redirecting in " + seconds + " seconds...";
    }, 1000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
