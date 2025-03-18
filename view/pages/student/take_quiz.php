<?php
// Handle the request
$quizID = $_GET['quiz_id'] ?? null;
$classroomID = $_GET['classroom_id'] ?? null;
$studentID = $_GET['student_id'] ?? null;

require_once('../../../controller/QuestionController.php');
$questions = $questionServices->fetchQuestions($quizID, $classroomID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .container { max-width: 800px; margin-top: 50px; }
        .btn-submit { width: 100%; }
        .pending-container { text-align: center; padding: 50px; }
        .pending-text { font-size: 20px; font-weight: bold; color: #555; }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-top: 20px;
        }
         /* Custom styles for the image */
        .responsive-image {
            max-width: 250px; /* Set a maximum width for larger screens */
            width: 100%; /* Make it responsive */
            height: auto; /* Maintain aspect ratio */
        }
        
        .choice {
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .drop-box {
            margin-top: 50px;
            width: 100%;
            height: 100px;
            border: 2px dashed #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4CAF50;
            font-weight: bold;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container mb-3">
        <a href="classroom.php?classroom_id=<?php echo $classroomID ?>" class="btn btn-danger mb-3">Back</a>
        <h2 class="text-center mb-4">Quiz</h2>

        <?php if (empty($questions)) : ?>
            <div class="pending-container">
                <p class="pending-text">Pending Questions... Please wait!</p>
                <div class="loader"></div>
            </div>
        <?php else : ?>
            <form method="POST" onsubmit="return validateForm()">
                <?php foreach ($questions as $index => $q) : ?>
                    <div class="card p-3 mb-3">

                        <p><strong><?php echo $index + 1; ?>. </strong><?php echo htmlspecialchars($q['question_description']); ?></p>
                        <div class="image-upload mb-2">
                            <div class="d-flex justify-content-center">
                                <img src="<?php echo $q['image_path']; ?>" class="img-fluid img-thumbnail responsive-image" alt="..."
                                    data-bs-toggle="modal" data-bs-target="#imageModal" 
                                    onclick="document.getElementById('modalImage').src='<?php echo $q['image_path']; ?>'">
                            </div>
                        </div>
                        <?php if ($q['question_type'] == 'isMultipleChoice') { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[<?php echo $q['question_id']; ?>]" value="<?php echo $q['a']; ?>" required>
                                <label class="form-check-label"><strong>A.</strong> <small><?php echo htmlspecialchars($q['a']); ?></small></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[<?php echo $q['question_id']; ?>]" value="<?php echo $q['b']; ?>">
                                <label class="form-check-label"><strong>B.</strong> <small><?php echo htmlspecialchars($q['b']); ?></small></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[<?php echo $q['question_id']; ?>]" value="<?php echo $q['c']; ?>">
                                <label class="form-check-label"><strong>C.</strong> <small><?php echo htmlspecialchars($q['c']); ?></small></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[<?php echo $q['question_id']; ?>]" value="<?php echo $q['d']; ?>">
                                <label class="form-check-label"><strong>D.</strong> <small><?php echo htmlspecialchars($q['d']); ?></small></label>
                            </div>
                        <?php }else if ($q['question_type'] == 'isEnumeration'){ ?>
                            <div class="row justify-content-center mt-1">
                                <div class="col-md-3 mb-1">
                                    <div class="choice card" draggable="true" id="choice_<?php echo $q['question_id']; ?>_1"><?php echo $q['a']; ?></div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="choice card" draggable="true" id="choice_<?php echo $q['question_id']; ?>_2"><?php echo $q['b']; ?></div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="choice card" draggable="true" id="choice_<?php echo $q['question_id']; ?>_3"><?php echo $q['c']; ?></div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="choice card" draggable="true" id="choice_<?php echo $q['question_id']; ?>_4"><?php echo $q['d']; ?></div>
                                </div>
                                <div class="drop-box card mt-5" id="dropBox_<?php echo $q['question_id']; ?>">Drop Here</div>
                                <input type="hidden" class="form-control" name="answers[<?php echo $q['question_id']; ?>]" id="hiddenInput_<?php echo $q['question_id']; ?>" placeholder="Your answer" required>
                            </div>
                        <?php } else { ?>
                            <input type="text" class="form-control" name="answers[<?php echo $q['question_id']; ?>]" placeholder="Your answer" required>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary btn-submit">Submit Quiz</button>
                </form>

        <?php endif; ?>
        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" class="img-fluid" alt="Large Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Reminder Modal -->
    <div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reminderModalLabel">Incomplete Answers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please drag and drop an answer for all enumeration questions before submitting.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
         // Select all choices and drop boxes
        const choices = document.querySelectorAll('.choice');
        const dropBoxes = document.querySelectorAll('.drop-box');

        // Add dragstart event listener to each choice
        choices.forEach(choice => {
            choice.addEventListener('dragstart', dragStart);
        });

        // Add dragover and drop event listeners to each drop box
        dropBoxes.forEach(dropBox => {
            dropBox.addEventListener('dragover', dragOver);
            dropBox.addEventListener('drop', (e) => drop(e, dropBox));
        });

        function dragStart(e) {
            e.dataTransfer.setData('text/plain', e.target.id); // Store the ID of the dragged element
        }

        function dragOver(e) {
            e.preventDefault(); // Prevent default to allow drop
        }

        function drop(e, dropBox) {
            e.preventDefault();
            const choiceId = e.dataTransfer.getData('text/plain'); // Get the ID of the dragged element
            const choiceElement = document.getElementById(choiceId); // Get the dragged element

            if (!choiceElement) {
                console.error("Dropped element not found.");
                return;
            }

            dropBox.textContent = `You dropped: ${choiceElement.textContent}`; // Update drop box text

            // Correctly extract the full question ID from the dropBox ID
            const questionId = dropBox.id.replace('dropBox_', ''); 

            const hiddenInput = document.getElementById(`hiddenInput_${questionId}`); // Get the corresponding hidden input

            if (hiddenInput) {
                hiddenInput.value = choiceElement.textContent; // Set the value to the text of the dropped choice
                console.log(`Updated hidden input: hiddenInput_${questionId} = ${choiceElement.textContent}`);
            } else {
                console.error(`Hidden input not found for ID: hiddenInput_${questionId}`);
            }
        }

        function validateForm() {
            let allFilled = true;
            const hiddenInputs = document.querySelectorAll('input[type="hidden"]');

            hiddenInputs.forEach(input => {
                if (!input.value.trim()) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                const modal = new bootstrap.Modal(document.getElementById('reminderModal'));
                modal.show();
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
