<?php 
    // Get parameters from the URL
    $classroomId = $_GET['classroom_id'] ?? null; 
    $instructorID = $_GET['instructor_id'] ?? null; 
    $quizID = $_GET['quiz_id'] ?? null; 
    include_once('../../../controller/QuestionController.php');

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
        <h2 class="mb-4">Create Questions</h2>

        <!-- Open the form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="quiz_id_fk" value="<?php echo $quizID; ?>">
            <input type="hidden" name="classroom_id_fk" value="<?php echo $classroomId; ?>">
            <input type="hidden" name="action" value="createQuestions">

            <?php if (!empty($_GET['mcq_count']) && $_GET['mcq_count'] > 0) : ?>
                <h3 class="mt-4">Multiple Choice Questions</h3>
                <?php for ($i = 1; $i <= $_GET['mcq_count']; $i++) : ?>
                    <div class="card mt-3 p-3">
                        <label>Question <?php echo $i; ?></label>
                        <div class="image-upload mb-2">
                            <input type="file" class="form-control" name="questions[<?php echo $i - 1; ?>][image_path]" accept="image/*" onchange="previewImage(event, <?php echo $i; ?>)">
                            <div id="imagePreview<?php echo $i; ?>" class="mt-2"></div>
                        </div>
                        <input type="hidden" name="questions[<?php echo $i - 1; ?>][question_type]" value="isMultipleChoice">
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][question_description]" placeholder="Enter question" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][a]" placeholder="Option A" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][b]" placeholder="Option B" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][c]" placeholder="Option C" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][d]" placeholder="Option D" required>
                        <input type="text" class="form-control" name="questions[<?php echo $i - 1; ?>][answer]" placeholder="Correct answer" required>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

            <?php if (!empty($_GET['id_count']) && $_GET['id_count'] > 0) : ?>
                <h3 class="mt-4">Identification Questions</h3>
                <?php for ($i = $_GET['mcq_count'] + 1; $i <= $_GET['mcq_count'] + $_GET['id_count']; $i++) : ?>
                    <div class="card mt-3 p-3">
                        <label>Question <?php echo $i; ?></label>
                        <div class="image-upload mb-2">
                            <input type="file" class="form-control" name="questions[<?php echo $i - 1; ?>][image_path]" accept="image/*" onchange="previewImage(event, <?php echo $i; ?>)">
                            <div id="imagePreview<?php echo $i; ?>" class="mt-2"></div>
                        </div>
                        <input type="hidden" name="questions[<?php echo $i - 1; ?>][question_type]" value="isIdentification">
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][question_description]" placeholder="Enter question" required>
                        <input type="text" class="form-control" name="questions[<?php echo $i - 1; ?>][answer]" placeholder="Correct answer" required>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
            
            <?php if (!empty($_GET['en_count']) && $_GET['en_count'] > 0) : ?>
                <h3 class="mt-4">Enumeration</h3>
                <?php for ($i = 1; $i <= $_GET['en_count']; $i++) : ?>
                    <div class="card mt-3 p-3">
                        <label>Question <?php echo $i; ?></label>
                        <div class="image-upload mb-2">
                            <input type="file" class="form-control" name="questions[<?php echo $i - 1; ?>][image_path]" accept="image/*" onchange="previewImage(event, <?php echo $i; ?>)">
                            <div id="imagePreview<?php echo $i; ?>" class="mt-2"></div>
                        </div>
                        <input type="hidden" name="questions[<?php echo $i - 1; ?>][question_type]" value="isEnumeration">
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][question_description]" placeholder="Enter question" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][a]" placeholder="Insert Here" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][b]" placeholder="Insert Here" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][c]" placeholder="Insert Here" required>
                        <input type="text" class="form-control mb-2" name="questions[<?php echo $i - 1; ?>][d]" placeholder="Insert Here" required>
                        <input type="text" class="form-control" name="questions[<?php echo $i - 1; ?>][answer]" placeholder="Correct answer" required>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary mt-4 mb-5">Save Questions</button>
        </form> 
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event, questionIndex) {
            const file = event.target.files[0];
            const imagePreviewDiv = document.getElementById(`imagePreview${questionIndex}`);
            const modalImage = document.getElementById('modalImage');

            // Clear previous content
            imagePreviewDiv.innerHTML = '';

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create an image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px'; // Set a fixed width for the preview
                    img.style.cursor = 'pointer';
                    img.classList.add('img-thumbnail');
                    
                    // Add click event to open modal
                    img.onclick = function() {
                        modalImage.src = e.target.result; // Set the modal image source
                        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                        imageModal.show(); // Show the modal
                    };

                    // Create a remove button
                    const removeButton = document.createElement('button');
                    removeButton.innerText = 'Remove';
                    removeButton.classList.add('btn', 'btn-danger', 'mt-2');
                    removeButton.onclick = function() {
                        event.target.value = ''; // Clear the file input
                        imagePreviewDiv.innerHTML = ''; // Clear the preview
                    };

                    // Append the image and remove button to the preview div
                    imagePreviewDiv.appendChild(img);
                    imagePreviewDiv.appendChild(removeButton);
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        }
    </script>
</body>
</html>