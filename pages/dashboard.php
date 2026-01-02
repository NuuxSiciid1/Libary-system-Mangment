<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}

include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';


?>

<div class="dashboard-contact" style="left: 0; top:0; position:absolute; width:85%; margin-left:280px; padding:20px;">
    <div class="container-fluid mt-4">
        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Dashboard</h3>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3">

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Books</h6>
                        <h2 class="fw-bold text-primary">
                            <?php
                            $qry = "SELECT COUNT(*) AS total FROM books";
                            $res = mysqli_query($conn, $qry);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['total'] ?? 0;
                            ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Members</h6>
                        <h2 class="fw-bold text-success">
                            <?php
                            $qry = "SELECT COUNT(*) AS total FROM members";
                            $res = mysqli_query($conn, $qry);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['total'] ?? 0;
                            ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Books Borrowed</h6>
                        <h2 class="fw-bold text-warning">
                            <?php
                            $qry = "SELECT COUNT(*) AS total FROM borrow_records WHERE status='borrowed'";
                            $res = mysqli_query($conn, $qry);
                            $row = mysqli_fetch_assoc($res);
                            echo $row['total'] ?? 0;
                            ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Overdue Books</h6>
                        <h2 class="fw-bold text-danger">
                            <?php
                            $result = $conn->query("SELECT COUNT(*) AS total FROM borrow_records WHERE status='overdue'");
                            $row = $result->fetch_assoc();
                            echo $row['total'] ?? 0;
                            ?>
                        </h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- Latest Borrowed Books -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Latest Borrowed Books</h5>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM borrow_records WHERE status='overdue'");
                $row = $result->fetch_assoc();
                echo $row['total'] ?? 0;
                ?>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Book Title</th>
                            <th>Member</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = "SELECT br.borrow_date, br.due_date, br.status,
                            b.title AS book_title,
                            m.name AS member_name
                        FROM borrow_records br
                        JOIN books b ON br.book_id = b.id
                        JOIN members m ON br.member_id = m.id
                        ORDER BY br.borrow_date DESC
                        LIMIT 5
                    ";

                        $result = mysqli_query($conn, $qry);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $statusClass = match ($row['status']) {
                                    'borrowed' => 'warning',
                                    'returned' => 'success',
                                    'overdue'  => 'danger',
                                };

                                echo "
                            <tr>
                                <td>{$i}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['member_name']}</td>
                                <td>{$row['borrow_date']}</td>
                                <td>{$row['due_date']}</td>
                                <td>
                                    <span class='badge bg-{$statusClass}'>
                                        {$row['status']}
                                    </span>
                                </td>
                            </tr>";
                                $i++;
                            }
                        } else {
                            echo "
                        <tr>
                            <td colspan='6' class='text-center text-muted py-4'>
                                No records found
                            </td>
                        </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>