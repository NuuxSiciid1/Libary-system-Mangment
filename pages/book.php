<?php
include '../servers/bookServer.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>


<main class="main-content " style="left: 0; top:0; position:absolute; width:auto; margin-left:280px; padding:20px;">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Book Management</h3>
    </div>

    <!-- ADD BOOK -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3" enctype="multipart/form-data">
                <?php if ($updateDate) : ?>
                    <div class="col-md-4">
                        <label class="form-label">Id</label>
                        <input readonly type="text" name="id" placeholder="Entre The New category" class="form-control" value="<?php echo $updateDate['id'] ?? '' ?>">
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label class="form-label">Book Title</label>
                    <input type="text" name="book_title" class="form-control" placeholder="Book title" value="<?php echo $updateDate['title'] ?? '' ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN" value="<?php echo $updateDate['isbn'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">QTY</label>
                    <input type="number" name="total_copies" class="form-control" placeholder="QTY" value="<?php echo $updateDate['quantity'] ?? '' ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select class="form-control" value="<?php echo $updateDate['category_id'] ?? '' ?>" name="category" required>
                        <option value="" disabled selected>Category</option>
                        <?php foreach ($categories as $category): ?>
                            <?php if ($updateDate): ?>
                                <option value="<?php echo $updateDate['category_id'] ?>" selected><?php echo $category['name'] ?></option>
                            <?php else: ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Author</label>
                    <select class="form-control" name="author" required>
                        <option value="" disabled selected>Author</option>
                        <?php foreach ($authors as $author): ?>
                            <?php if ($updateDate): ?>
                                <option value="<?php echo $updateDate['author_id'] ?>" selected><?php echo $author['name'] ?></option>
                            <?php else: ?>
                                <option value="<?= $author['id'] ?>"><?= $author['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Publisher</label>
                    <select class="form-control" name="publisher" value="<?php echo $updateDate['publisher_id'] ?? '' ?>" required>
                        <option value="" disabled selected>Publisher</option>
                        <?php foreach ($publishers as $publisher): ?>
                            <?php if ($updateDate): ?>
                                <option value="<?php echo $updateDate['publisher_id'] ?>" selected><?php echo $publisher['name'] ?></option>
                            <?php else: ?>
                                <option value="<?= $publisher['id'] ?>"><?= $publisher['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="col-md-4">
                    <label class="form-label">Book Location</label>
                    <select class="form-control" name="locationb" value="<?php echo $updateDate['location_id'] ?? '' ?>" required>
                        <option value="" disabled selected>Location</option>
                        <?php foreach ($locations as $location): ?>
                            <?php if ($updateDate): ?>
                                <option value="<?php echo $updateDate['location_id'] ?>" selected><?php echo $location['location_code'] ?></option>
                            <?php else: ?>
                                <option value="<?= $location['id'] ?>"><?= $location['location_code'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="col-md-4">
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="book_cover" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Publish Year</label>
                    <input value="<?php echo $updateDate['publish_year'] ?? '' ?>" type="number" name="publish_year"
                        class="form-control"
                        min="1000" max="<?= date('Y') ?>"
                        required>
                </div>


                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($updateDate): ?>
                        <button type="submit" name="update" class=" me-2 btn btn-success">Update Book</button>
                        <a href="book.php" class="btn btn-danger">Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Book</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Title</th>
                    <th>QTY</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Cover Image</th>
                    <th>Publish Year</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <?php
            if (count($books) > 0) {
                //for loop
                for ($bookRow = 0; $bookRow < count($books); $bookRow++) {
                    echo "<tr>";
                    echo "<td>" . $books[$bookRow]['id'] . "</td>";
                    echo "<td>" . $books[$bookRow]['title'] . "</td>";
                    echo "<td>" . $books[$bookRow]['quantity'] . "</td>";
                    echo "<td>" . $books[$bookRow]['author_name'] . "</td>";
                    echo "<td>" . $books[$bookRow]['publisher_name'] . "</td>";
                    echo "<td>";
                    if ($books[$bookRow]['cover_image']) {
                        echo "<img src='../assets/images/" . $books[$bookRow]['cover_image'] . "' width='60px'>";
                    } else {
                        echo "No Image";
                    }
                    echo "</td>";
                    echo "<td>" . $books[$bookRow]['publish_year'] . "</td>";
                    echo "<td><a href='?edit={$books[$bookRow]['id']}' class='btn btn-sm btn-warning'>Edit</td>";
                    echo "<td><a href='?delete={$books[$bookRow]['id']}' class='btn btn-sm btn-danger'>Delete</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td>No Book As been Uploaded</td></tr>";
            }
            ?>
        </table>
    </div>

</main>


<?php include '../layout/footer.php'; ?>