<?php

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit();
}

include '../db.php';

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
