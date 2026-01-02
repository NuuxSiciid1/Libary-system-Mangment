<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit();
}

include '../db.php';

/* CREATE */
if (isset($_POST['save'])) {
    $publisher = trim($_POST['publisher']);

    if ($publisher !== '') {
        mysqli_query($conn, "INSERT INTO publishers (name) VALUES ('$publisher')");
    }

    header("Location: publishers.php");
    exit();
}

/* READ SINGLE */
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM publishers WHERE id=$id");
    $UpdateDate = mysqli_fetch_assoc($res);
}

/* UPDATE */
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $publisher = trim($_POST['publisher']);

    mysqli_query($conn, "UPDATE publishers SET name='$publisher' WHERE id=$id");
    header("Location: publishers.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM publishers WHERE id=$id");
    header("Location: publishers.php");
    exit();
}

/* READ ALL */
$res = mysqli_query($conn, "SELECT * FROM publishers");
$publishers = mysqli_fetch_all($res, MYSQLI_ASSOC);
