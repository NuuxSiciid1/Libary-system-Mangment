<?php
// ==========================
// INCLUDE FILES
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';

// ==========================
$category   = $_GET['category']   ?? '';
$author     = $_GET['author']     ?? '';
$startDate  = $_GET['start_date'] ?? '';
$endDate    = $_GET['end_date']   ?? '';

// ==========================
$authors     = mysqli_fetch_all(mysqli_query($conn, "SELECT id, name FROM authors"), MYSQLI_ASSOC);
$categories  = mysqli_fetch_all(mysqli_query($conn, "SELECT id, name FROM categories"), MYSQLI_ASSOC);


// ==========================
$sql = "
SELECT 
    books.id,
    books.title,
    books.isbn,
    books.quantity,
    authors.name AS author_name,
    categories.name AS category_name
FROM books
LEFT JOIN authors ON books.author_id = authors.id
LEFT JOIN categories ON books.category_id = categories.id
WHERE 1=1
";

if ($category !== '') {
    $sql .= " AND books.category_id = " . (int)$category;
}

if ($author !== '') {
    $sql .= " AND books.author_id = " . (int)$author;
}

if ($startDate !== '') {
    $sql .= " AND books.created_at >= '$startDate'";
}

if ($endDate !== '') {
    $sql .= " AND books.created_at <= '$endDate'";
}

// ==========================

$result = mysqli_query($conn, $sql);
$books  = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">

    <div class="container-fluid p-3">

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">

                    <div class="col-md-2">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="category">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($category == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Author</label>
                        <select class="form-control" name="author">
                            <option value="">All Authors</option>
                            <?php foreach ($authors as $a): ?>
                                <option value="<?= $a['id'] ?>" <?= ($author == $a['id']) ? 'selected' : '' ?>>
                                    <?= $a['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $endDate ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm">Search</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-secondary">Excel</button>
                <button class="btn btn-outline-secondary">PDF</button>
                <button class="btn btn-outline-secondary">CSV</button>
                <button class="btn btn-outline-secondary">Print</button>
            </div>
            <input type="text" class="form-control form-control-sm w-25" placeholder="Search book...">
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Copies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($books): ?>
                                <?php foreach ($books as $book): ?>
                                    <tr>
                                        <td><?= $book['id'] ?></td>
                                        <td><?= $book['title'] ?></td>
                                        <td><?= $book['isbn'] ?></td>
                                        <td><?= $book['author_name'] ?></td>
                                        <td><?= $book['category_name'] ?></td>
                                        <td><?= $book['quantity'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        No books found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
