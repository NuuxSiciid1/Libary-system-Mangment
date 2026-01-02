<?php
include '../servers/users.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>


<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Add User</h3>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3">

                <?php if ($UpdateDate) : ?>
                    <div class="col-md-3">
                        <label class="form-label">ID</label>
                        <input readonly type="text" name="id" class="form-control"
                            value="<?php echo $UpdateDate['id']; ?>">
                    </div>
                <?php endif; ?>

                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?php echo $UpdateDate['user_name'] ?? ''; ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?php echo $UpdateDate['email'] ?? ''; ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="" disabled <?= !$UpdateDate ? 'selected' : '' ?>>Role</option>

                        <?php foreach ($Roles as $role): ?>
                            <option value="<?= $role['id'] ?>"
                                <?= ($UpdateDate && $UpdateDate['role_id'] == $role['id']) ? 'selected' : '' ?>>
                                <?= $role['role_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="col-md-2 d-flex align-items-end mt-3">
                    <?php if ($UpdateDate) : ?>
                        <button type="submit" name="update" class="me-2 btn btn-primary">Update</button>
                        <a href="users.php" class="btn btn-danger">Cancel</a>
                    <?php else : ?>
                        <button type="submit" name="save" class="btn btn-primary">Add User</button>
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
                        <th>Email</th>
                        <th>Role</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0) : ?>
                        <?php foreach ($users as $row) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['user_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role_name']; ?></td>
                                <td>
                                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                                <td>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>