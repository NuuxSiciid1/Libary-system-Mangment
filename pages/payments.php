<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit();
}

include '../servers/payment.php';
include '../layout/header.php';
include '../layout/sidebar.php';

// Add new payment
if (isset($_POST['save'])) {
    $member_id = $_POST['member_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];
    $description = $_POST['reason'];

    if ($member_id == "" || $amount == "" || $payment_date == "" || $description == "") {
        echo "All fields are required";
        header("Location: payments.php");
        exit();
    }

    $qry = "INSERT INTO payments (member_id, amount, payment_date, reason)
            VALUES ('$member_id', '$amount', '$payment_date', '$description')";
    mysqli_query($conn, $qry);
    header("Location: payments.php");
    exit();
}

// Update payment
$updateData = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSinglePayment = "SELECT * FROM payments WHERE id = $editId";
    $resPayment = mysqli_query($conn, $getSinglePayment);
    $updateData = mysqli_fetch_assoc($resPayment);
}

// Handle update submission
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $member_id = $_POST['member_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $description = $_POST['reason'];

    $qry = "UPDATE payments SET 
                member_id='$member_id',
                amount='$amount',
                payment_date='$payment_date',
                reason='$description'
            WHERE id='$id'";
    mysqli_query($conn, $qry);
    header("Location: payments.php");
    exit();
}

// Delete payment
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM payments WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);
    header("Location: payments.php");
    exit();
}

// Get all payments
$getPayments = "SELECT payments.*, members.name AS member_name 
                FROM payments 
                LEFT JOIN members ON payments.member_id = members.id 
                ORDER BY payments.id DESC";
$resPayments = mysqli_query($conn, $getPayments);
$payments = mysqli_fetch_all($resPayments, MYSQLI_ASSOC);

// Get members for dropdown
$membersRes = mysqli_query($conn, "SELECT * FROM members");
$members = mysqli_fetch_all($membersRes, MYSQLI_ASSOC);
?>

<div style="left: 0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Add Payment</h3>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3">
                <?php if ($updateData) : ?>
                    <input type="hidden" name="id" value="<?php echo $updateData['id']; ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Member</label>
                    <select name="member_id" class="form-control" required>
                        <option value="">Select Member</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?php echo $member['id']; ?>"
                                <?php echo ($updateData && $updateData['member_id'] == $member['id']) ? 'selected' : ''; ?>>
                                <?php echo $member['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control"
                        value="<?php echo $updateData['amount'] ?? ''; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control"
                        value="<?php echo $updateData['payment_date'] ?? date('Y-m-d'); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Description</label>
                    <input type="text" name="reason" class="form-control"
                        value="<?php echo $updateData['reason'] ?? ''; ?>">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($updateData): ?>
                        <button type="submit" name="update" class="me-2 btn btn-primary">Update</button>
                        <a href="payments.php" class="btn btn-danger">Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Payment</button>
                    <?php endif; ?>
                </div>
            </form>

            <div class="card-body table-responsive mt-4">
                <table class="table table-hover align-middle">
                    <thead>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Description</th>
                        <th colspan="2">Actions</th>
                    </thead>
                    <tbody>
                        <?php if (count($payments) > 0): ?>
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td><?php echo $payment['id']; ?></td>
                                    <td><?php echo $payment['member_name']; ?></td>
                                    <td><?php echo $payment['amount']; ?></td>
                                    <td><?php echo $payment['payment_date']; ?></td>
                                    <td><?php echo $payment['reason']; ?></td>
                                    <td><a href="?edit=<?php echo $payment['id']; ?>" class="btn btn-sm btn-warning">Edit</a></td>
                                    <td><a href="?delete=<?php echo $payment['id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No payments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>