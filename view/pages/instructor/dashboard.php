<?php 
    include_once('../../../middleware/InstructorMiddleware.php');
    $successMessage = isset($_GET['success']) ? $_GET['success'] : '';
    $instructorId = $_SESSION['instructor_id'] ?? null;
    
    if (!$instructorId) {
        header("Location: instructor.php?error=Instructor not logged in.");
        exit();
    }
    $classroomList = $classroomService->showInstructorClassroom($instructorId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f1f3f4;
        }
        .classroom-card {
            border-radius: 10px;
            transition: 0.3s ease-in-out;
            cursor: pointer;
        }
        .classroom-card:hover {
            transform: scale(1.03);
        }
        .classroom-header {
            background-color: #4285F4;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            font-size: 18px;
        }
        .classroom-body {
            padding: 15px;
            background-color: white;
            border-radius: 0 0 10px 10px;
        }
        .classroom-code {
            background: #e8f0fe;
            color: #1a73e8;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .share-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>
<body>
<script>
    function togglePassword(inputId, iconId) {
        var passwordInput = document.getElementById(inputId);
        var eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">Instructor Dashboard</a>
            <div>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    Change Password
                </button>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <p><b>Intructor Fullname:</b> <?php echo $_SESSION['instructor_fullname']?></p>
        <h2>My Classrooms</h2>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-thumbs-up fa-3x text-success"></i>
                        <p class="mt-3"><?php echo htmlspecialchars($successMessage); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Classroom Modal -->
        <div class="modal fade" id="addClassroomModal" tabindex="-1" aria-labelledby="addClassroomModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClassroomModalLabel">Create Classroom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="createClassroom">
                            <div class="mb-3">
                                <label for="classroom_title" class="form-label">Classroom Title</label>
                                <input type="text" class="form-control" id="classroom_title" name="classroom_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="classroom_description" class="form-label">Classroom Description</label>
                                <textarea class="form-control" id="classroom_description" name="classroom_description" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Classroom</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Button to trigger create classroom modal -->
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addClassroomModal">
            Create Classroom
        </button>

        <!-- Display Classrooms -->
        <div class="row">
            <?php if (!empty($classroomList)) : ?>
                <?php foreach ($classroomList as $classroom) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="classroom-card shadow">
                            <div class="classroom-header">
                                <?php echo htmlspecialchars($classroom['classroom_title']); ?>
                                <button class="share-btn float-end" onclick="copyToClipboard(event, '<?php echo $classroom['code']; ?>')" title="Share">
                                    <i class="fas fa-share-alt text-white"></i>
                                </button>
                                <button class="share-btn float-end mx-2 edit-btn" data-id="<?php echo $classroom['id']; ?>" data-title="<?php echo htmlspecialchars($classroom['classroom_title']); ?>" data-description="<?php echo htmlspecialchars($classroom['classroom_description']); ?>" data-status="<?php echo htmlspecialchars($classroom['isActive']); ?>" data-bs-toggle="modal" data-bs-target="#editClassroomModal">
                                    <i class="fas fa-pen text-white"></i>
                                </button>
                            </div>
                            <a href="classroom.php?classroom_id=<?php echo $classroom['classroom_id']; ?>" class="text-decoration-none text-dark classroom-link">
                                <div class="classroom-body">
                                    <p><?php echo htmlspecialchars($classroom['classroom_description']); ?></p>
                                    <span class="classroom-code"><?php echo htmlspecialchars($classroom['code']); ?></span>
                                </div>
                            </a>
                           
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No classrooms found.</p>
            <?php endif; ?>
        </div>



           <!-- Edit Classroom Modal -->
            <div class="modal fade" id="editClassroomModal" tabindex="-1" aria-labelledby="editClassroomModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editClassroomModalLabel">Edit Classroom</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editClassroomForm" action="" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="updateClassroom">
                                <input type="hidden" id="edit_classroom_id" name="id">
                                <div class="mb-3">
                                    <label for="edit_classroom_title" class="form-label">Classroom Title</label>
                                    <input type="text" class="form-control" id="edit_classroom_title" name="classroom_title" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_classroom_description" class="form-label">Classroom Description</label>
                                    <textarea class="form-control" id="edit_classroom_description" name="classroom_description" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_classroom_status" class="form-label">Status</label>
                                    <select class="form-control" id="edit_classroom_status" name="classroom_status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="saveChangesBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Confirm Update Modal -->
            <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="confirmUpdateModalLabel">Confirm Changes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to save these changes?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Yes, Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

    </div>

        <!-- Enrollment Modal -->
        <div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="enrollmentModalLabel">Enrollment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="changePassword">

                        <!-- Old Password -->
                        <div class="mb-3">
                            <label for="oldpassword" class="form-label">Old Password</label>
                            <div class="input-group">
                                <input type="password" id="oldpassword" name="old_password" class="form-control form-control-lg" required/>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('oldpassword', 'togglePassword1')">
                                    <i id="togglePassword1" class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" id="new_password" name="new_password" class="form-control form-control-lg" required/>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password', 'togglePassword2')">
                                    <i id="togglePassword2" class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required/>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password', 'togglePassword3')">
                                    <i id="togglePassword3" class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div id="errorMessage" class="text-danger"></div>
                        <button type="submit" class="btn btn-success">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show success modal if there's a success message
        <?php if (!empty($successMessage)) : ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        <?php endif; ?>

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
                let editButtons = document.querySelectorAll(".edit-btn");
                let confirmUpdateModal = new bootstrap.Modal(document.getElementById('confirmUpdateModal'));
                let editModal = new bootstrap.Modal(document.getElementById('editClassroomModal'));

                let selectedClassroomId = null; // Store the classroom ID for confirmation

                editButtons.forEach(button => {
                    button.addEventListener("click", function (event) {
                        event.stopPropagation(); // Prevents clicking the whole card

                        // Get classroom details from data attributes
                        let classroomId = this.getAttribute("data-id");
                        let title = this.getAttribute("data-title");
                        let description = this.getAttribute("data-description");
                        let status = this.getAttribute("data-status");

                        console.log("Editing Classroom:", { classroomId, title, description, status });

                        // Use setTimeout to ensure inputs are populated properly before showing the modal
                        setTimeout(() => {
                            document.getElementById('edit_classroom_id').value = classroomId;
                            document.getElementById('edit_classroom_title').value = title;
                            document.getElementById('edit_classroom_description').value = description;
                            document.getElementById('edit_classroom_status').value = status == 1 ? 1 : 0;
                        }, 300); // Small delay before updating inputs

                        // Show the Edit Modal
                        editModal.show();
                    });
                });

                    // When clicking "Save Changes," show confirmation modal instead
                    document.getElementById("saveChangesBtn").addEventListener("click", function (event) {
                        event.preventDefault(); // Prevent immediate submission

                        selectedClassroomId = document.getElementById('edit_classroom_id').value; // Store the ID
                        confirmUpdateModal.show(); // Show the confirmation modal
                    });

                    // When clicking "Yes, Save Changes," submit the form
                    document.getElementById("confirmUpdateBtn").addEventListener("click", function () {
                        document.getElementById("editClassroomForm").submit(); // Submit the form
                    });
                });


        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const errorMessage = urlParams.get('error');

            if (errorMessage) {
                document.getElementById("modalMessage").textContent = errorMessage;
                let enrollmentModal = new bootstrap.Modal(document.getElementById("enrollmentModal"));
                enrollmentModal.show();
            }
        });


        // Confirmation before submitting changes
        function confirmUpdate(event) {
            event.preventDefault(); // Stop form submission

            if (confirm("Are you sure you want to save these changes?")) {
                document.getElementById("editClassroomForm").submit();
            }
        }


    </script>

</body>
</html>
