<?php
// ==========================
// LAYOUT
// ==========================
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';

// ==========================
// READ FILTERS
// ==========================
$category  = $_GET['category'] ?? '';

// ==========================
// FETCH CATEGORIES (FOR FILTER)
// ==========================
$categories = mysqli_fetch_all(
    mysqli_query($conn, "SELECT id, name FROM categories"),
    MYSQLI_ASSOC
);

// ==========================
// BUILD CATEGORY REPORT QUERY
// ==========================
$sql = "
SELECT 
    categories.id,
    categories.name AS category_name,
    COUNT(DISTINCT books.id) AS total_titles,
    SUM(books.quantity) AS total_copies,
    SUM(CASE WHEN books.quantity > 0 THEN books.quantity ELSE 0 END) AS available_copies,
    SUM(CASE WHEN books.quantity = 0 THEN 1 ELSE 0 END) AS borrowed_titles
FROM categories
LEFT JOIN books ON books.category_id = categories.id
WHERE 1=1
";

if ($category !== '') {
    $sql .= " AND categories.id = " . (int)$category;
}

$sql .= " GROUP BY categories.id";

// ==========================
// EXECUTE QUERY
// ==========================
$result = mysqli_query($conn, $sql);
$rows   = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- ==========================
     CATEGORY REPORT UI
========================== -->

<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">

    <div class="container-fluid p-3">

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($category == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Total Titles</th>
                                <th>Total Copies</th>
                                <th>Available Copies</th>
                                <th>Borrowed Titles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($rows): ?>
                                <?php foreach ($rows as $r): ?>
                                    <tr>
                                        <td><?= $r['category_name'] ?></td>
                                        <td><?= $r['total_titles'] ?? 0 ?></td>
                                        <td><?= $r['total_copies'] ?? 0 ?></td>
                                        <td><?= $r['available_copies'] ?? 0 ?></td>
                                        <td><?= $r['borrowed_titles'] ?? 0 ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No data found
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
