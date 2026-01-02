<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}

include '../db.php';
// SAVE
if (isset($_POST['save'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    if ($name == "" || $email == "" || $role == "") {
        echo "all fields needed ";
    }

    $qry = "INSERT INTO users (user_name, email, role_id) VALUES ('$name', '$email', '$role')";
    mysqli_query($conn, $qry);
    header("Location: users.php");
    exit();
}

// GET SINGLE USER
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingle = "SELECT * FROM users WHERE id = $editId";
    $resSingle = mysqli_query($conn, $getSingle);
    $UpdateDate = mysqli_fetch_assoc($resSingle);
}

// UPDATE
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $qry = "UPDATE users
    SET user_name='$name', email='$email', role_id='$role'
    WHERE id=$id
";
    mysqli_query($conn, $qry);
    header("Location: users.php");
    exit();
}

//Delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM users WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: users.php");
    exit();
}


$getBooks = "SELECT books.id, books.title, books.isbn, books.quantity, books.cover_image, authors.name as author_name, categories.name as category_name FROM books LEFT JOIN authors ON books.author_id = authors.id LEFT JOIN categories ON books.category_id = categories.id where 1=1 ";
$getUsers = "SELECT users.id, users.user_name, users.email, roles.role_name as role_name FROM users LEFT JOIN roles ON users.role_id = roles.id where 1=1 ";
$resUsers = mysqli_query($conn, $getUsers);
$users = mysqli_fetch_all($resUsers, MYSQLI_ASSOC);

//get all roles
$getRoles = "SELECT id, role_name FROM roles";
$resRoles = mysqli_query($conn, $getRoles);
$Roles = mysqli_fetch_all($resRoles, MYSQLI_ASSOC);
