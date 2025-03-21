
<h2 class="mb-4">Available Quizzes</h2>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createQuizModal">Create Quiz</button>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#insertCopiedQuizModal">Insert Copied Quiz</button>
        <div class="row">
            <?php if ($quizzes): ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <?php 
                        $createdDate = date("F j, Y h:i A", strtotime($quiz['created_date']));
                        $expirationDate = $quiz['expiration'] ? date("F j, Y h:i A", strtotime($quiz['expiration'])) : 'No Expiration';
                        $expirationTimestamp = strtotime($quiz['expiration']);
                        $currentTimestamp = time();
                        $isExpired = $expirationTimestamp && $expirationTimestamp < $currentTimestamp;

                        // Check if quiz has questions
                        $hasQuestions = $quiz['has_questions'] == 1;
                    ?>
                    <div class="col-md-4 mb-4">
                        <a href="<?= (!$isExpired && !$hasQuestions) ? "create_quiz.php?quiz_id={$quiz['quiz_id']}&classroom_id={$classroomId}&instructor_id={$instructorId}" : '#' ?>" 
   class="text-decoration-none <?= ($isExpired || !$hasQuestions) ? 'disabled-link' : '' ?>">


                            <div class="card quiz-card <?= $isExpired ? 'border-danger expire text-white' : 'border-success' ?>" 
                                data-expiration="<?= $expirationTimestamp ?>">
                                <div class="card-body p-0 mb-1">
                                    <div class="d-flex flex-row-reverse">
                                        <?php if ($hasQuestions){?>
                                        <button class="btn btn-success" onclick="copyToClipboard(event, '<?php echo $quiz['quiz_id']; ?>')" title="Share">
                                            <i class="fas fa-share-alt text-white"></i>
                                        </button>
                                        <?php }?>
                                    </div>
                                    <h5 class="card-title"> <?= htmlspecialchars($quiz['quiz_title']) ?> </h5>
                                    <p class="card-text"> <?= htmlspecialchars($quiz['quiz_description']) ?> </p>
                                    <div class="quiz-meta mt-2 text-muted">
                                        <i class="fa fa-calendar"></i> Created: <?= $createdDate ?> <br>
                                        <i class="fa fa-clock"></i> Expires: <?= $expirationDate ?>
                                    </div>
                                        <!-- Indicate if questions are already created -->
                                        <?php if ($hasQuestions): ?>
                                            <p class="text-success mb-0"><i class="fa fa-check-circle"></i> Questions Already Created</p>
                                        <?php else: ?>
                                            <p class="text-danger mb-0"><i class="fa fa-exclamation-circle"></i> No Questions Yet</p>
                                        <?php endif; ?>
                                            <!-- Countdown Timer -->
                                            <div class="countdown m-0 text-primary"></div>
                                    </div>
                                    </a>
                                    <div class="d-flex justify-content-end m-0">
                                        <!-- Edit Button -->
                                        <button class="btn btn-info btn-sm"
                                            onclick="showStudentQuizScores('<?= $quiz['quiz_id'] ?>')"
                                            data-bs-toggle="modal">
                                            <i class="fa fa-star"></i> Scores
                                        </button>

                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm mx-2" 
                                            onclick="editQuiz('<?= $quiz['quiz_id'] ?>', '<?= htmlspecialchars($quiz['quiz_title']) ?>', '<?= htmlspecialchars($quiz['quiz_description']) ?>', '<?= $quiz['expiration'] ?>')"
                                            data-bs-toggle="modal" data-bs-target="#editQuizModal">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= $quiz['quiz_id'] ?>')" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                            </div>

                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <p>No quizzes available.</p>
            <?php endif; ?>
        </div>
    </div>


    <!-- Insert Existing Quiz -->
    <div class="modal fade" id="insertCopiedQuizModal" tabindex="-1" aria-labelledby="insertCopiedQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertCopiedQuizModalLabel">Insert Copied Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="insertCopiedQuiz">
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" class="form-control" name="code" required>
                            <input type="hidden" name="classroom_id" value="<?php echo $_GET['classroom_id']?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
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

    <!-- Modal for Quiz Scores -->
    <div class="modal fade" id="quizScoresModal" tabindex="-1" aria-labelledby="quizScoresModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizScoresModalLabel">Quiz Scores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="scoresTable">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Scores will be populated here -->
                        </tbody>
                        <button class="btn btn-primary my-2" onclick="generatePDF()"><i class="fa fa-print"></i> Print Scores</button>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

            let classroomTitle = ""; // Variable to hold classroom title
            let classroomDescription = ""; // Variable to hold classroom description
            let instructorFullname = ""; // Variable to hold instructor's name
            let quizTitle = ""; // Variable to hold quiz title

            function showStudentQuizScores(quizId) {
                // Make an AJAX request to fetch quiz scores
                $.ajax({
                    url: 'scores.php', // Replace with the actual path to your API endpoint
                    type: 'GET',
                    data: { quiz_id: quizId },
                    dataType: 'json', // Expect a JSON response
                    success: function(data) {
                        // Clear the existing table body
                        $('#scoresTable tbody').empty();

                        // Populate the table with the returned data
                        if (data.length > 0) {
                            data.forEach(function(score) {
                                $('#scoresTable tbody').append(`
                                    <tr>
                                        <td>${score.student_fullname}</td>
                                        <td class='${(score.score / score.total) >= 0.5 ? "text-success" : "text-danger"}'>${score.score}/${score.total}</td>
                                    </tr>
                                `);
                            });
                             // Set classroom and quiz details (you may need to adjust this based on your data structure)
                            classroomTitle = data[0].classroom_title; // Assuming classroom title is part of the score data
                            classroomDescription = data[0].classroom_description; // Assuming classroom description is part of the score data
                            instructorFullname = data[0].instructor_fullname; // Assuming instructor's name is part of the score data
                            quizTitle = data[0].quiz_title; // Assuming quiz title is part of the score data
                        } else {
                            $('#scoresTable tbody').append('<tr><td colspan="3" class="text-center">No scores available</td></tr>');
                        }

                        // Show the modal
                        $('#quizScoresModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching scores: ", error);
                        alert("An error occurred while fetching scores.");
                    }
                });
            }



            document.addEventListener("DOMContentLoaded", function () {
                    function generatePDF() {
                        const { jsPDF } = window.jspdf;
                        const doc = new jsPDF();

                        // Ensure autoTable is available
                        if (typeof doc.autoTable !== "function") {
                            console.error("autoTable plugin is not loaded correctly.");
                            alert("Error: autoTable plugin is missing.");
                            return;
                        }

                        // Set up the header
                        doc.setFontSize(20);
                        doc.text(classroomTitle, 14, 20);
                        doc.setFontSize(12);
                        doc.text("Instructor: " + instructorFullname, 14, 30);
                        doc.text("Quiz: " + quizTitle, 14, 40);
                        doc.text("Date: " + new Date().toLocaleDateString(), 14, 50);

                        // Prepare the scores data
                        const scoresData = [];
                        $('#scoresTable tbody tr').each(function() {
                            const studentName = $(this).find('td').eq(0).text();
                            const score = $(this).find('td').eq(1).text();
                            scoresData.push([studentName, score]);
                        });

                       // Add the scores table
                        // Add the scores table
                        doc.autoTable({
                            startY: 60,
                            head: [['Student Name', 'Score']],
                            body: scoresData.map(row => [
                                row[0], // No padding needed
                                row[1]  // No padding needed
                            ]),
                        });
                        // Save the PDF
                        doc.save("Quiz_Scores_Report.pdf");
                    }

                    // Attach function to button click
                    document.querySelector("button[onclick='generatePDF()']").addEventListener("click", generatePDF);
                });

         // Copy classroom code to clipboard
        function copyToClipboard(event, code) {
            event.stopPropagation(); // Prevents the click from affecting the parent link
            navigator.clipboard.writeText(code).then(() => {
                alert('Classroom code copied: ' + code);
            }).catch(err => {
                console.error('Error copying text: ', err);
            });
        }

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