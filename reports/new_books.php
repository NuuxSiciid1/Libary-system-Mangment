<?php
// ==========================
// LAYOUT
// ==========================
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';

// ==========================
// FILTERS
// ==========================
$startDate = $_GET['start_date'] ?? '';
$endDate   = $_GET['end_date']   ?? '';

// ==========================
// BUILD QUERY
// ==========================
$sql = "
SELECT 
    books.id,
    books.title,
    books.isbn,
    books.quantity,
    books.created_at,
    authors.name AS author_name,
    categories.name AS category_name
FROM books
LEFT JOIN authors ON books.author_id = authors.id
LEFT JOIN categories ON books.category_id = categories.id
WHERE 1=1
";

if ($startDate !== '') {
    $sql .= " AND books.created_at >= '$startDate'";
}

if ($endDate !== '') {
    $sql .= " AND books.created_at <= '$endDate'";
}

// newest first
$sql .= " ORDER BY books.created_at DESC";

// ==========================
// EXECUTE
// ==========================
$result = mysqli_query($conn, $sql);
$books  = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- ==========================
     NEW BOOKS REPORT UI
========================== -->

<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">

    <div class="container-fluid p-3">

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
                    </div>

                    <div class="col-md-3">
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
            <span class="text-muted small">
                Showing recently added books
            </span>
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
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($books): ?>
                                <?php foreach ($books as $b): ?>
                                    <tr>
                                        <td><?= $b['id'] ?></td>
                                        <td><?= $b['title'] ?></td>
                                        <td><?= $b['isbn'] ?></td>
                                        <td><?= $b['author_name'] ?></td>
                                        <td><?= $b['category_name'] ?></td>
                                        <td><?= $b['quantity'] ?></td>
                                        <td><?= date('Y-m-d', strtotime($b['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No new books found
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
