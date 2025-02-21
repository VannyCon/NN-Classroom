<?php 
    include_once('../../../controller/AdminController.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-1">Instructor Approval List</h2>
        <small>Manage instructor, settings, and system configurations.</small>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Instructor ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Approval Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($getAllNeedApprovalIntructor)): ?>
                    <?php foreach ($getAllNeedApprovalIntructor as $instructor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($instructor['id']); ?></td>
                            <td><?php echo htmlspecialchars($instructor['instructor_id']); ?></td>
                            <td><?php echo htmlspecialchars($instructor['instructor_username']); ?></td>
                            <td><?php echo htmlspecialchars($instructor['instructor_fullname']); ?></td>
                            <td>
                                <?php 
                                    if($instructor['isApproved'] == 0){
                                        echo '<span class="badge bg-warning">Pending</span>';
                                    }else if($instructor['isApproved'] == 2){
                                        echo '<span class="badge bg-success">Approved</span>';
                                    }else{
                                        echo '<span class="badge bg-danger">Rejected</span>';
                                    }
                                ?>
                                <?php  $instructor['isApproved'] ?  : '<span class="badge bg-warning">Pending</span>'; ?>
                            </td>
                            <td>
                                <?php if($instructor['isApproved'] != 2){?>
                                    <div class="d-flex gap-2">
                                        <form action="" method="post">
                                            <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor['instructor_id']) ?>" />
                                            <input type="hidden" name="action" value="approvedInstructor">
                                            <button type="submit" name="approve_instructor" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <?php 
                                        if($instructor['isApproved'] != 1){
                                        ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor['instructor_id']) ?>" />
                                                <input type="hidden" name="action" value="rejectInstructor">
                                                <button type="submit" name="approve_instructor" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        <?php }?>
                                    </div>
                                </td>
                            <?php }?>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No instructors pending approval.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>
