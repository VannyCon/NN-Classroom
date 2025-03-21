<?php 
    include_once('../../../middleware/StudentMiddleware.php');
    $successMessage = $_GET['success'] ?? '';
    $classroomId = $_GET['classroom_id'] ?? null; 
    $studentID = $_GET['student_id'] ?? null; 
    
    if (!$classroomId) {
        header("Location: classroom.php?error=Instructor not logged in or Classroom doesn't exist.");
        exit();
    }
    if($studentID != $_SESSION['student_id']){
        header("Location: ../../../404.php");
        exit();
    }
    $quizzes = $quizService->getQuizzes($classroomId);
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="classroom.php?classroom_id=<?php echo $classroomId?>" class="btn btn-danger mb-3">Back</a>
        <h2 class="mb-4">Take Quizzes</h2>

        
    </div>

    <!-- Create Quiz Modal -->
    <div class="modal fade" id="createQuizModal" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createQuizModalLabel">Create Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="createQuiz">
                        <div class="mb-3">
                            <label class="form-label">Quiz Title</label>
                            <input type="text" class="form-control" name="quiz_title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quiz Description</label>
                            <textarea class="form-control" name="quiz_description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expiration Date & Time</label>
                            <input type="datetime-local" class="form-control" name="expiration" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Quiz Modal -->
    <div class="modal fade" id="editQuizModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="updateQuiz">
                        <input type="hidden" name="quiz_id" id="editQuizId">
                        <div class="mb-3">
                            <label>Quiz Title</label>
                            <input type="text" class="form-control" id="editQuizTitle" name="quiz_title" required>
                        </div>
                        <div class="mb-3">
                            <label>Quiz Description</label>
                            <textarea class="form-control" id="editQuizDescription" name="quiz_description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Expiration Date</label>
                            <input type="datetime-local" class="form-control" id="editQuizExpiration" name="expiration" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this quiz?</p>
                        <input type="hidden" name="quiz_id" id="deleteQuizId">
                        <input type="hidden" name="action" value="deleteQuiz">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="successMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateCountdowns() {
                const now = new Date().getTime();
                document.querySelectorAll(".quiz-card").forEach(card => {
                    const expirationAttr = card.getAttribute("data-expiration");
                    if (!expirationAttr) return;

                    const expiration = parseInt(expirationAttr) * 1000; // Convert to milliseconds
                    const countdownElem = card.querySelector(".countdown");

                    if (!countdownElem) return;

                    if (expiration < now) {
                        countdownElem.innerHTML = "<strong class='text-danger'>Expired</strong>";
                        return;
                    }

                    const remainingTime = expiration - now;
                    const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                    countdownElem.innerHTML = `<strong class="text-warning">Remaining: ${days}d ${hours}h ${minutes}m ${seconds}s</strong>`;
                });
            }

            setInterval(updateCountdowns, 1000); // Update every second
            updateCountdowns(); // Run immediately on page load
        });

        function editQuiz(id, title, description, expiration) {
            document.getElementById('editQuizId').value = id;
            document.getElementById('editQuizTitle').value = title;
            document.getElementById('editQuizDescription').value = description;

            if (expiration) {
                let dateObj = new Date(expiration);
                let offset = dateObj.getTimezoneOffset() * 60000;
                let localDate = new Date(dateObj.getTime() - offset);
                let formattedDate = localDate.toISOString().slice(0, 16);
                document.getElementById('editQuizExpiration').value = formattedDate;
            } else {
                document.getElementById('editQuizExpiration').value = "";
            }
        }

        function confirmDelete(quizId) {
            document.getElementById('deleteQuizId').value = quizId;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
