<?php
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header("Location: ../auth/login.php");
    
}


?>


<?php
// Fetch late fees from the database

if(isset($_GET['pay'])){
    $payId = $_GET['pay'];

    // mark late fee as paid
    $qry = "UPDATE late_fees SET paid = 1 WHERE id = '$payId'";
    mysqli_query($conn, $qry);

    header("Location: late_fees.php");
    exit();
}

$getLateFees = "
    SELECT 
        lf.id,
        m.name AS member_name,
        b.title AS book_title,
        lf.days_late,
        lf.amount,
        lf.paid
    FROM late_fees lf
    JOIN borrow_records br ON br.id = lf.borrow_id
    JOIN members m ON m.id = br.member_id
    JOIN books b ON b.id = br.book_id
    ORDER BY lf.id DESC
";

$resLateFees = mysqli_query($conn, $getLateFees);
$lateFees = mysqli_fetch_all($resLateFees, MYSQLI_ASSOC);
?>


?>


<div style="left:0; top:0; position:absolute; min-width:80%; width:auto; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Late Fees</h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Book</th>
                    <th>Days Late</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php
            if(count($lateFees) > 0){
                foreach($lateFees as $row){
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['member_name']}</td>";
                    echo "<td>{$row['book_title']}</td>";
                    echo "<td>{$row['days_late']}</td>";
                    echo "<td>{$row['amount']}</td>";

                    if($row['paid'] == 1){
                        echo "<td><span class='badge bg-success'>Paid</span></td>";
                        echo "<td>-</td>";
                    } else {
                        echo "<td><span class='badge bg-danger'>Unpaid</span></td>";
                        echo "<td>
                                <a href='?pay={$row['id']}' class='btn btn-sm btn-primary'>
                                    Pay
                                </a>
                              </td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Late Fees</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>
