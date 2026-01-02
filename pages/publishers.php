<?php
include '../servers/publisher.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <h3 class="fw-bold mb-4">
        <?= $UpdateDate ? 'Edit Publisher' : 'Add Publisher'; ?>
    </h3>

    <div class="card mb-4">
        <div class="card-body">
            <form method="post" class="row g-3">

                <?php if ($UpdateDate): ?>
                    <input type="hidden" name="id" value="<?= $UpdateDate['id']; ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Publisher Name</label>
                    <input type="text" name="publisher" class="form-control"
                        value="<?= $UpdateDate['name'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($UpdateDate): ?>
                        <button name="update" class="btn btn-primary me-2">Update</button>
                        <a href="publishers.php" class="btn btn-danger">Cancel</a>
                    <?php else: ?>
                        <button name="save" class="btn btn-primary">Add Publisher</button>
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
                    <th>Name</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($publishers as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><a href="?edit=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
                        <td><a href="?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>