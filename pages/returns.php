<?php
include '../servers/returnServer.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<form method="post" style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">
  <h3>Return Book</h3>
  <button name="return" class="btn btn-success">Confirm Return</button>
  <a name="cancel" href="borrow.php" class="btn btn-warning">Confirm Return</a>
</form>