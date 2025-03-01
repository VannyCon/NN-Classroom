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
    
?>
