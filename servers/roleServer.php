<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}

include '../db.php';

// SAVE
if (isset($_POST['save'])) {
    $role = $_POST['role'];

    if ($role == "") {
        header("Location: role.php");
        exit();
    }

    $qry = "INSERT INTO roles (role_name) VALUES ('$role')";
    mysqli_query($conn, $qry);
    header("Location: role.php");
    exit();
}

// GET SINGLE FOR EDIT
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingle = "SELECT * FROM roles WHERE id = $editId";
    $resSingle = mysqli_query($conn, $getSingle);
    $UpdateDate = mysqli_fetch_assoc($resSingle);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];

    $qry = "UPDATE roles SET role_name = '$role' WHERE id = '$id'";
    mysqli_query($conn, $qry);
    header("Location: role.php");
    exit();
}

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM roles WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: role.php");
    exit();
}


// GET ALL
$getRoles = "SELECT * FROM roles";
$resRoles = mysqli_query($conn, $getRoles);
$roles = mysqli_fetch_all($resRoles, MYSQLI_ASSOC);
