<?php
include '../layout/header.php';
include '../servers/categories.php';
include '../layout/sidebar.php';
?>

<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Categories</h3>
    </div>
    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3" enctype="multipart/form-data">
                <?php if ($UpdateDate) : ?>
                    <div class="col-md-4">
                        <label class="form-label">Id</label>
                        <input readonly type="text" name="id" placeholder="Entre The New category" class="form-control" value="<?php echo $UpdateDate['id'] ?? '' ?>">
                    </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="category" required placeholder="Entre The New category" class="form-control" value="<?php echo $UpdateDate['name'] ?? '' ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($UpdateDate) : ?>
                        <button type="submit" name="update" class="me-2 btn btn-primary">Update category</button>
                        <a href="categories.php" class="btn btn-danger">Cancel</a>
                    <?php else : ?>
                        <button type="submit" name="save" class="btn btn-primary">Add category</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <th>ID</th>
                <th>category_name</th>
                <th colspan="2">Actions</th>
            </thead>
            <tbody>
                <?php
                if (count($categories) > 0) {
                    for ($categoryRow = 0; $categoryRow < count($categories); $categoryRow++) {
                        echo "<tr>";
                        echo "<td>" . $categories[$categoryRow]['id'] . "</td>";
                        echo "<td>" . $categories[$categoryRow]['name'] . "</td>";
                        echo "<td> <a href='?edit={$categories[$categoryRow]['id']}' class='btn btn-sm btn-warning'> Edit </td>";
                        echo "<td> <a href='?delete={$categories[$categoryRow]['id']}' class='btn btn-sm btn-danger'>Delete</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "No Categories";
                }
                ?>
            </tbody>

        </table>
    </div>
</div>