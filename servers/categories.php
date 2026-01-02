<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}


include '../db.php';

//save
if (isset($_POST['save'])) {
    $category = $_POST['category'];

    $qry = "INSERT INTO categories (name) VALUES('$category')";
    mysqli_query($conn, $qry);
    header("Location: categories.php");
    exit();
}

//Edit
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingleCategory = "SELECT * FROM categories WHERE id = $editId";
    $resCategory = mysqli_query($conn, $getSingleCategory);
    $UpdateDate = mysqli_fetch_assoc($resCategory);
    // var_dump($UpdateDate['name']);
}

//update
if (isset($_POST['update'])) {
    $category = $_POST['category'];
    $id = $_POST['id'];
    $qry = "UPDATE categories SET NAME = '$category' WHERE id = '$id'";
    mysqli_query($conn, $qry);

    header("Location: categories.php");
    exit();
}

//delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM categories WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: categories.php");
    exit();
}


$getCategory = "SELECT * FROM categories";
$resCategories = mysqli_query($conn, $getCategory);
$categories = mysqli_fetch_all($resCategories, MYSQLI_ASSOC);


?>