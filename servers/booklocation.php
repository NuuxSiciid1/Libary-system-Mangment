
<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header("Location: ../auth/login.php");
    
}



include '../db.php';
?>
<?php
// SAVE
if (isset($_POST['save'])) {
    $location = $_POST['location'];


    $qry = "INSERT INTO book_locations (location_code) VALUES ('$location')";
    mysqli_query($conn, $qry) or die(mysqli_error($conn));
    // header("Location: book_locations.php.php");
    // exit();
}

// GET SINGLE FOR EDIT
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingle = "SELECT * FROM book_locations WHERE id = $editId";
    $resSingle = mysqli_query($conn, $getSingle);
    $UpdateDate = mysqli_fetch_assoc($resSingle);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $location = $_POST['location'];

    $qry = "UPDATE book_locations SET location_code = '$location' WHERE id = '$id'";
    mysqli_query($conn, $qry);
    header("Location: book_locations.php");
    exit();
}
//Delete 
if(isset($_GET['delete'])){
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM book_locations WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: book_locations.php");
    exit();  
}

// GET ALL
$getLocations = "SELECT * FROM book_locations";
$resLocations = mysqli_query($conn, $getLocations);
$locations = mysqli_fetch_all($resLocations, MYSQLI_ASSOC);

?>