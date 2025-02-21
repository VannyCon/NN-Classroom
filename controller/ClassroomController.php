<?php
require_once('../../../../services/TriviaServices.php');
    $triviaService = new TriviaServices();
    $triviadata = $triviaService->getAllTrivia();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create') {
        // Clean input fields
        $title = TriviaServices::clean('title', 'post');
        $body = TriviaServices::clean('body', 'post');

        // Generate unique directory for the images
        $triviaId = 'TRIVIA-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $imageDir = "../../../../data/images/trivia/$triviaId/";
        

        if (!is_dir($imageDir) && !mkdir($imageDir, 0777, true)) {
            die("Failed to create image directory.");
        }

        // Handle file uploads
        $uploadedFiles = [];
        $targetDir = ""; // This will store the first valid image path

        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($_FILES['photos']['name'] as $index => $photoName) {
                $photoTmpName = $_FILES['photos']['tmp_name'][$index];
                $photoError = $_FILES['photos']['error'][$index];
                $photoSize = $_FILES['photos']['size'][$index];

                // Validate file upload
                if ($photoError !== UPLOAD_ERR_OK) continue;
                if ($photoSize > 10 * 1024 * 1024) continue; // Max size 10MB

                // Validate file type
                $fileType = mime_content_type($photoTmpName);
                $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
                if (!isset($allowedTypes[$fileType])) continue;

                // Set new file name based on triviaId
                $extension = $allowedTypes[$fileType];
                $newFileName = $index === 0 ? "$triviaId.$extension" : "$triviaId-$index.$extension";
                $targetFile = $imageDir . $newFileName;

                // Move uploaded file
                if (move_uploaded_file($photoTmpName, $targetFile)) {
                    $uploadedFiles[] = $targetFile;

                    // Set $targetDir to the first valid image path (JPG or PNG only)
                    if (empty($targetDir) && in_array($extension, ['jpg', 'png'])) {
                        $targetDir = $targetFile;
                    }
                }
            }
    }

    // If no JPG or PNG was uploaded, default to the first uploaded image
    if (empty($targetDir) && !empty($uploadedFiles)) {
        $targetDir = $uploadedFiles[0];
    }

    $targetDir = substr($targetDir, 3);

    // Insert into the database with the full image path
    if ($triviaService->create($triviaId, $title, $body, $targetDir)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error creating trivia.";
    }

   
}

 //UPDATE
 if (isset($_GET['ID']) && $title="update") {
    $id = $_GET['ID'];
    // Check if form is submitted
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        // Clean input data
        $title = TriviaServices::clean('title', 'post');
        $body = TriviaServices::clean('body', 'post');
        // Call create method to add the new owner
        $updateStatus = $triviaService->update($id, $title, $body);
        // Optionally, you can redirect or show a success message after creation
        if ($updateStatus == true) {
            // Redirect to index.php
            header("Location: index.php"); 
            exit(); // Important to stop the script after the redirection
        } 
    }
} 

////// DELETE
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $body = TriviaServices::clean('id', 'post');
    error_log("Attempting to delete owner with ID: $id"); // Log the ID
    $result = $triviaService->delete($id);
    
    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        error_log("Deletion failed for ID: $id");
        header("Location: index.php");
        exit();
    }
}