<?php
include '../servers/booklocation.php';
include '../layout/header.php';
include '../layout/sidebar.php';

?>

<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Add Book Location</h3>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3">

                <?php if ($UpdateDate) : ?>
                    <div class="col-md-4">
                        <label class="form-label">ID</label>
                        <input readonly type="text" name="id" class="form-control"
                               value="<?php echo $UpdateDate['id']; ?>">
                    </div>
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Location Name</label>
                    <input type="text" name="location" class="form-control"
                           placeholder="Enter book location"
                           value="<?php echo $UpdateDate['location_code'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($UpdateDate) : ?>
                        <button type="submit" name="update" class="me-2 btn btn-primary">Update</button>
                        <a href="book_locations.php" class="btn btn-danger">Cancel</a>
                    <?php else : ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Location</button>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($locations) > 0) : ?>
                        <?php foreach ($locations as $row) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['location_code']; ?></td>
                                <td>
                                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
