<?php 
    include_once('../../../controller/ClassroomController.php');

    // Display error messages if any
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
    }
    $reviews = $classroomService->getAllReviewsByClassroomID($classroomId);
?>

    <h2 class="mb-4 mt-0">Available Reviews</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createReviewModal">Create Review</button>
    
    <div class="row">
        <?php if ($reviews && count($reviews) > 0): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($review['reviewer_title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($review['reviewer_description']) ?></p>
                            <?php if (!empty($review['docs_path'])): ?>
                                <a href="<?= htmlspecialchars($review['docs_path']) ?>" class="btn btn-info" target="_blank">View Document</a>
                            <?php endif; ?>
                            <p class="text-muted">Submitted on: <?= date("F j, Y", strtotime($review['created_date'])) ?></p>
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" 
                               onclick="populateUpdateModal('<?= $review['reviewer_id'] ?>', '<?= htmlspecialchars(addslashes($review['reviewer_title'])) ?>', '<?= htmlspecialchars(addslashes($review['reviewer_description'])) ?>')">
                               Update
                            </a>
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                               onclick="setDeleteId(<?= $review['id'] ?>)">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No reviewers available.</div>
            </div>
        <?php endif; ?>
    

<!-- Create Review Modal -->
<div class="modal fade" id="createReviewModal" tabindex="-1" aria-labelledby="createReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createReviewModalLabel">Create New Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="submitReview">
                    
                    <div class="mb-3">
                        <label for="new_reviewer_title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="reviewer_title" id="new_reviewer_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_reviewer_description" class="form-label">Description</label>
                        <textarea class="form-control" name="reviewer_description" id="new_reviewer_description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="docs_path" class="form-label">Document (Optional)</label>
                        <input type="file" class="form-control" name="docs_path" id="docs_path">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="updateReview">
                    <input type="hidden" name="review_id" id="review_id">
                    <div class="mb-3">
                        <label for="reviewer_title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="reviewer_title" id="reviewer_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="reviewer_description" class="form-label">Description</label>
                        <textarea class="form-control" name="reviewer_description" id="reviewer_description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="update_docs_path" class="form-label">Document (Optional - Leave empty to keep current document)</label>
                        <input type="file" class="form-control" name="docs_path" id="update_docs_path">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this review?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    <input type="hidden" name="id" id="delete_review_id">
                    <input type="hidden" name="action" value="deleteReview">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bootstrap will handle modal behavior, no need for inert attribute management
});

function populateUpdateModal(id, title, description) {
    console.log("Titles: " + title);
    console.log("Description: " + description);
    document.getElementById('review_id').value = id;
    document.getElementById('reviewer_title').value = title;
    document.getElementById('reviewer_description').value = description;
}

function setDeleteId(id) {
    document.getElementById('delete_review_id').value = id;
}
</script>