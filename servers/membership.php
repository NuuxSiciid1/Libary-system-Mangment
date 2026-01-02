<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}

include '../db.php';

?>
<?php
// SAVE
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $duration = $_POST['duration_months'];
    $limit = $_POST['borrow_limit'];

    if ($name == "" || $price == "" || $duration == "" || $limit == "") {
        header("Location: membership_plans.php");
        exit();
    }

    $qry = "INSERT INTO membership_plans (name, price, duration_months, borrow_limit)
            VALUES ('$name', '$price', '$duration', '$limit')";
    mysqli_query($conn, $qry);
    header("Location: membership_plans.php");
    exit();
}

// GET SINGLE FOR EDIT
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingle = "SELECT * FROM membership_plans WHERE id = $editId";
    $resSingle = mysqli_query($conn, $getSingle);
    $UpdateDate = mysqli_fetch_assoc($resSingle);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $duration = $_POST['duration_months'];
    $limit = $_POST['borrow_limit'];

    $qry = "UPDATE membership_plans 
            SET name='$name', price='$price', duration_months='$duration', borrow_limit='$limit'
            WHERE id='$id'";
    mysqli_query($conn, $qry);
    header("Location: membership_plans.php");
    exit();
}

//DELETE
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM membership_plans WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: membership_plans.php");
    exit();
}


// GET ALL
$getPlans = "SELECT * FROM membership_plans";
$resPlans = mysqli_query($conn, $getPlans);
$plans = mysqli_fetch_all($resPlans, MYSQLI_ASSOC);

?>