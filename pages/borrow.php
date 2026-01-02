<?php
include '../layout/header.php';
include '../layout/sidebar.php';
include '../servers/borrow.php';
?>


<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">
  <h3>Borrow Book</h3>

  <form method="post" class="row g-3">
    <div class="col-md-4">
      <label>Member</label>
      <select name="member_id" class="form-control" required>
        <option value="">Select</option>
        <?php while ($m = mysqli_fetch_assoc($members)) { ?>
          <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="col-md-4">
      <label>Book</label>
      <select name="book_id" class="form-control" required>
        <option value="">Select</option>
        <?php while ($b = mysqli_fetch_assoc($books)) { ?>
          <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="col-md-4 d-flex align-items-end">
      <button name="save" class="btn btn-primary">Borrow</button>
    </div>
  </form>

  <hr>

  <table class="table table-bordered mt-3">
    <tr>
      <th>ID</th>
      <th>Member</th>
      <th>Book</th>
      <th>Borrow</th>
      <th>Due</th>
      <th>Status</th>
      <th colspan="2">Action</th>
    </tr>

    <?php foreach ($borrows as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['member'] ?></td>
        <td><?= $r['title'] ?></td>
        <td><?= $r['borrow_date'] ?></td>
        <td><?= $r['due_date'] ?></td>
        <td><?= $r['status'] ?></td>
        <td>
          <?php if ($r['status'] == 'borrowed'): ?>
            <a href="returns.php?borrow=<?= $r['id'] ?>" class="btn btn-sm btn-success">Return</a>
          <?php endif; ?>
        </td>
        <td>
          <a href="borrow.php?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>