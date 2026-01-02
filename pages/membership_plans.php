<?php

include '../servers/membership.php';
include '../layout/header.php';
include '../layout/sidebar.php';

?>

<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Membership Plans</h3>
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

                <div class="col-md-3">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?php echo $UpdateDate['name'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control"
                        value="<?php echo $UpdateDate['price'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Duration (Months)</label>
                    <input type="number" name="duration_months" class="form-control"
                        value="<?php echo $UpdateDate['duration_months'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Borrow Limit</label>
                    <input type="number" name="borrow_limit" class="form-control"
                        value="<?php echo $UpdateDate['borrow_limit'] ?? ''; ?>" required>
                </div>

                <div class="col-md-5 d-flex gap-2 mt-3 align-items-end">
                    <?php if ($UpdateDate) : ?>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="membership_plans.php" class="btn btn-danger">Cancel</a>
                    <?php else : ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Plan</button>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Duration (Months)</th>
                        <th>Borrow Limit</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plans as $row) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['duration_months']; ?></td>
                            <td><?php echo $row['borrow_limit']; ?></td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>