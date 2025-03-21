<?php 
    include_once('../../../middleware/InstructorMiddleware.php');

    // Get parameters from the URL
    $classroomId = $_GET['classroom_id'] ?? null; 
    $instructorID = $_GET['instructor_id'] ?? null; 
    $quizID = $_GET['quiz_id'] ?? null; 

    // Redirect if any required parameter is missing
    if (!$classroomId || !$instructorID || !$quizID) {
        header("Location: ../../../404.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Choose Count of Question</h2>

        <form method="GET" action="quiz.php">
            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizID); ?>">
            <input type="hidden" name="classroom_id" value="<?php echo htmlspecialchars($classroomId); ?>">
            <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructorID); ?>">

            <div class="row">
                <div class="col-md-4">
                    <label for="mcq_count" class="form-label">Number of Multiple-Choice Questions</label>
                    <select class="form-select" id="mcq_count" name="mcq_count">
                        <?php for ($i = 0; $i <= 50; $i += 5) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="id_count" class="form-label">Number of Identification Questions</label>
                    <select class="form-select" id="id_count" name="id_count">
                        <?php for ($i = 0; $i <= 50; $i += 5) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="en_count" class="form-label">Number of Enumeration</label>
                    <select class="form-select" id="en_count" name="en_count">
                        <?php for ($i = 0; $i <= 50; $i += 5) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Generate Questions</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
