<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}

include '../db.php';


?>

<?php
/* SAVE BORROW */
if (isset($_POST['save'])) {
    $member = $_POST['member_id'];
    $book = $_POST['book_id'];

    // check quantity
    $qry = mysqli_query($conn, "SELECT quantity FROM books WHERE id=$book");
    $bookData = mysqli_fetch_assoc($qry);

    if ($bookData['quantity'] <= 0) {
        header("Location: borrow.php");
        exit();
    }

    mysqli_query($conn, "
        INSERT INTO borrow_records (member_id,book_id,borrow_date,due_date,status)
        VALUES ($member,$book,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 14 DAY),'borrowed')
    ");

    mysqli_query($conn, "UPDATE books SET quantity = quantity - 1 WHERE id=$book");

    header("Location: borrow.php");
    exit();
}

/* DELETE BORROW*/
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM late_fees WHERE borrow_id = $id");
    mysqli_query($conn, "DELETE FROM borrow_records WHERE id = $id");

    header("Location: borrow.php");
    exit();
}


/* GET DATA */
$members = mysqli_query($conn, "SELECT id,name FROM members");
$books = mysqli_query($conn, "SELECT id,title FROM books WHERE quantity>0");

$borrowsQ = mysqli_query($conn, "
    SELECT br.id,m.name AS member,b.title,br.borrow_date,br.due_date,br.status
    FROM borrow_records br
    JOIN members m ON m.id=br.member_id
    JOIN books b ON b.id=br.book_id
");
$borrows = mysqli_fetch_all($borrowsQ, MYSQLI_ASSOC);
