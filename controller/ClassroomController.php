<?php 
    require_once('../../../services/ClassroomServices.php');

    $classroomService = new ClassroomServices();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'createClassroom') {
        
        if (empty($_POST['classroom_title']) || empty($_POST['classroom_description'])) {
            header("Location: instructor.php?error=All fields are required.");
            exit();
        }

        // Generate Classroom ID
        $classroomId = 'CLASSROOM-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Get Instructor ID
        $instructorId = $_SESSION['instructor_id'] ?? null;
        if (!$instructorId) {
            header("Location: instructor.php?error=Instructor not logged in.");
            exit();
        }
        
        // Generate Random Code
        $randomCode = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8));
        
        // Get Form Data
        $classroomTitle = $_POST['classroom_title'];
        $classroomDescription = $_POST['classroom_description'];
        
        // Save to Database
        $status = $classroomService->createClassroom($classroomId, $classroomTitle, $classroomDescription, $instructorId, $randomCode);
        
        if ($status) {
            header("Location: dashboard.php?success=Classroom created successfully.");
            exit();
        } else {
            header("Location: instructor.php?error=Failed to create classroom.");
            exit();
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'updateClassroom') {

        // Get Form Data
        $id = $_POST['id'];
        $classroomTitle = $_POST['classroom_title'];
        $classroomDescription = $_POST['classroom_description'];
        $classroomStatus = $_POST['classroom_status'];
        
        // Save to Database
        $status = $classroomService->updateClassroom($id, $classroomTitle, $classroomDescription, $classroomStatus);
        
        if ($status) {
            header("Location: dashboard.php?success=Classroom created successfully.");
            exit();
        } else {
            header("Location: instructor.php?error=Failed to create classroom.");
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'updateStudentStatus') {
        $studentId = $_POST['student_id'] ?? null;
        $status = $_POST['status'] ?? null;
    
        if ($studentId === null || $status === null) {
            echo json_encode(['success' => false, 'message' => 'Invalid request parameters']);
            exit();
        }
    
        $updateSuccess = $classroomService->updateStudentStatus($studentId, $status);
    
        if ($updateSuccess) {
            echo json_encode(['success' => true, 'message' => 'Student status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update student status']);
        }
        exit();
    }

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'submitReview') {
        // Start session if not already started
    
        // Validate input
        $reviewerTitle = $_POST['reviewer_title'];
        $reviewerDescription = $_POST['reviewer_description'];
        $instructorId = "INSTRUCTOR-7821556"; // Assuming instructor ID is stored in session
        $classroomId = "CLASSROOM-725541"; // Assuming classroom ID is stored in session
    
        if (empty($reviewerTitle) || empty($reviewerDescription) || empty($instructorId) || empty($classroomId)) {
            header("Location: reviewer.php?error=All fields are required.");
            exit();
        }
    
        // Generate unique reviewer ID
        $reviewerID = "REVIEWER-" . uniqid(); // Using uniqid for better uniqueness
        $uploadDir = "../../../data/documents/" . $reviewerID . "/";
    
        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                header("Location: reviewer.php?error=Failed to create directory.");
                exit();
            }
        }
    
        // Handle file upload
        $docsPath = '';
        if (isset($_FILES['docs_path']) && $_FILES['docs_path']['error'] == UPLOAD_ERR_OK) {
            $fileName = basename($_FILES["docs_path"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
    
            // Validate file type (add more types as needed)
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
            if (!in_array($_FILES['docs_path']['type'], $allowedTypes)) {
                header("Location: reviewer.php?error=Invalid file type.");
                exit();
            }
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["docs_path"]["tmp_name"], $targetFilePath)) {
                $docsPath = $targetFilePath; // Store the path to the uploaded file
            } else {
                header("Location: reviewer.php?error=File upload failed.");
                exit();
            }
        }
    
        // Save to Database
        $status = $classroomService->createReview($reviewerID, $reviewerTitle, $reviewerDescription, $docsPath, $instructorId, $classroomId);
    
        if ($status) {
            header("Location: reviewer.php?success=Review submitted successfully.");
            exit();
        } else {
            header("Location: reviewer.php?error=Failed to submit review.");
            exit();
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'updateReview') {
        // Start session if not already started
    
        // Validate input
        $reviewerID = $_POST['review_id'];
        $reviewerTitle = $_POST['reviewer_title'];
        $reviewerDescription = $_POST['reviewer_description'];
    
        // Generate unique reviewer ID path
        $uploadDir = "../../../data/documents/" . $reviewerID . "/";
    
        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                header("Location: reviewer.php?error=Failed to create directory.");
                exit();
            }
        }
    
        // Handle file upload
        $docsPath = null; // Initialize as null
        if (isset($_FILES['docs_path']) && $_FILES['docs_path']['error'] == UPLOAD_ERR_OK) {
            $fileName = basename($_FILES["docs_path"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
    
            // Validate file type (add more types as needed)
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
            if (!in_array($_FILES['docs_path']['type'], $allowedTypes)) {
                header("Location: reviewer.php?error=Invalid file type.");
                exit();
            }
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["docs_path"]["tmp_name"], $targetFilePath)) {
                $docsPath = $targetFilePath; // Store the path to the uploaded file
            } else {
                header("Location: reviewer.php?error=File upload failed.");
                exit();
            }
        }
    
        // Save to Database
        $status = $classroomService->updateReview($reviewerID, $reviewerTitle, $reviewerDescription, $docsPath);
    
        if ($status) {
            header("Location: reviewer.php?success=Review updated successfully.");
            exit();
        } else {
            header("Location: reviewer.php?error=Failed to update review.");
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'deleteReview') {
        $id = $_POST['id'];
        
        $status = $classroomService->deleteReview($id);
        
      
        if ($status) {
            header("Location: reviewer.php?success=Deleted successfully.");
            exit();
        } else {
            header("Location: reviewer.php?error=Failed to deleted review.");
            exit();
        }
    }
    
?>
