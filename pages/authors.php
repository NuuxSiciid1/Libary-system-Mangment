<?php
include '../servers/authorsServer.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <?= $UpdateData ? 'Edit Author' : 'Add Author'; ?>
        </h3>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post" class="row g-3">

                <?php if ($UpdateData): ?>
                    <input type="hidden" name="id" value="<?= $UpdateData['id']; ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Author Name</label>
                    <input
                        type="text"
                        name="author"
                        class="form-control"
                        required
                        value="<?= $UpdateData['name'] ?? ''; ?>">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($UpdateData): ?>
                        <button type="submit" name="update" class="btn btn-primary me-2">Update</button>
                        <a href="authors.php" class="btn btn-danger">Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Author</button>
                    <?php endif; ?>
                </div>

            </form>
        </div>
    </div>

    <div class="card table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Author Name</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td>
                            <a href="?edit=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                        <td>
                            <a href="?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this author?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>