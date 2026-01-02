<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit();
}

include '../db.php';

/* =====================
   CREATE
===================== */
if (isset($_POST['save'])) {
    $author = trim($_POST['author']);

    if ($author === "") {
        header("Location: authors.php");
        exit();
    }

    $qry = "INSERT INTO authors (name) VALUES ('$author')";
    mysqli_query($conn, $qry);

    header("Location: authors.php");
    exit();
}


$UpdateData = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM authors WHERE id = $editId");
    $UpdateData = mysqli_fetch_assoc($res);
}


if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $author = trim($_POST['author']);

    mysqli_query($conn, "UPDATE authors SET name = '$author' WHERE id = $id");

    header("Location: authors.php");
    exit();
}

//  ==========   DELETE
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM authors WHERE id = $deleteId");

    header("Location: authors.php");
    exit();
}


$resAuthor = mysqli_query($conn, "SELECT * FROM authors");
$authors = mysqli_fetch_all($resAuthor, MYSQLI_ASSOC);
