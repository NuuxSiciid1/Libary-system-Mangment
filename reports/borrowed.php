<?php
// ==========================
// LAYOUT
// ==========================
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';

// ==========================
$member     = $_GET['member']     ?? '';
$book       = $_GET['book']       ?? '';
$startDate  = $_GET['start_date'] ?? '';
$endDate    = $_GET['end_date']   ?? '';

// ==========================
$members = mysqli_fetch_all(
    mysqli_query($conn, "SELECT id, name FROM members"),
    MYSQLI_ASSOC
);

$booksList = mysqli_fetch_all(
    mysqli_query($conn, "SELECT id, title FROM books"),
    MYSQLI_ASSOC
);

// ==========================
$sql = "
SELECT 
    borrow_records.id,
    books.title AS book_title,
    members.name AS member_name,
    borrow_records.borrow_date,
    borrow_records.due_date,
    return_records.return_date
FROM borrow_records
LEFT JOIN books ON borrow_records.book_id = books.id
LEFT JOIN members ON borrow_records.member_id = members.id
LEFT JOIN return_records ON borrow_records.id = return_records.borrow_id
WHERE 1=1
";

if ($member !== '') {
    $sql .= " AND borrow_records.member_id = " .$member;
}

if ($book !== '') {
    $sql .= " AND borrow_records.book_id = " .$book;
}

if ($startDate !== '') {
    $sql .= " AND borrow_records.borrow_date >= '$startDate'";
}

if ($endDate !== '') {
    $sql .= " AND borrow_records.borrow_date <= '$endDate'";
}

$sql .= " ORDER BY borrow_records.borrow_date DESC";

// ==========================
$result  = mysqli_query($conn, $sql);
$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">

    <div class="container-fluid p-3">

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Member</label>
                        <select name="member" class="form-control">
                            <option value="">All Members</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m['id'] ?>" <?= ($member == $m['id']) ? 'selected' : '' ?>>
                                    <?= $m['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Book</label>
                        <select name="book" class="form-control">
                            <option value="">All Books</option>
                            <?php foreach ($booksList as $b): ?>
                                <option value="<?= $b['id'] ?>" <?= ($book == $b['id']) ? 'selected' : '' ?>>
                                    <?= $b['title'] ?>
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
            <input type="text" class="form-control form-control-sm w-25" placeholder="Search...">
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Book</th>
                                <th>Member</th>
                                <th>Borrow Date</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($records): ?>
                            <?php foreach ($records as $r): ?>
                                <tr>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= $r['book_title'] ?></td>
                                    <td><?= $r['member_name'] ?></td>
                                    <td><?= $r['borrow_date'] ?></td>
                                    <td><?= $r['due_date'] ?></td>
                                    <td><?= $r['return_date'] ?: 'No return' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    No records found
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
