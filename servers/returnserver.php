
<?php
include '../db.php';

$borrowId = $_GET['borrow'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT book_id,due_date FROM borrow_records WHERE id=$borrowId
"));

if (isset($_POST['return'])) {

  if ($data['status'] === 'returned') {
    header("Location: borrow.php");
    exit();
  }


  $today = date('Y-m-d');

  mysqli_query($conn, "
    UPDATE borrow_records SET status='returned' WHERE id=$borrowId
  ");

  mysqli_query(
    $conn,
    "
    UPDATE books SET quantity = quantity + 1 WHERE id=" . $data['book_id']
  );


  $daysLate = floor((strtotime($today) - strtotime($data['due_date'])) / 86400);


  if ($daysLate > 0) {
    $amount = $daysLate * 1;
    mysqli_query($conn, "
      INSERT INTO late_fees (borrow_id,days_late,amount,paid)
      VALUES ($borrowId,$daysLate,$amount,0)
    ");
  }

  header("Location: borrow.php");
}


?>