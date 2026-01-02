<?php
include '../layout/header.php';
include '../layout/sidebar.php';
include '../servers/member.php';

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
}


include '../db.php';

// SAVE
if (isset($_POST['save'])) {
    $member = $_POST['member'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $plan = $_POST['plan'];

    if ($member == "") {
        header("Location: members.php");
        exit();
    }

    $qry = "INSERT INTO members (name, email, phone, plan_id) VALUES ('$member', '$email', '$phone', '$plan')";
    mysqli_query($conn, $qry);
    header("Location: members.php");
    exit();
}

// GET SINGLE FOR EDIT
$UpdateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingle = "SELECT * FROM members WHERE id = $editId";
    $resSingle = mysqli_query($conn, $getSingle);
    $UpdateDate = mysqli_fetch_assoc($resSingle);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $member = $_POST['member'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $plan = $_POST['plan'];

    $qry = "UPDATE members SET name = '$member', email = '$email', phone = '$phone',  plan_id = '$plan'   WHERE id = '$id'";
    mysqli_query($conn, $qry);
    header("Location: members.php");
    exit();
}

//DELETE
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM payments WHERE member_id = $deleteId");
    mysqli_query($conn, "DELETE FROM members WHERE id = $deleteId");

    header("Location: members.php");
    exit();
}



// GET ALL
$getMembers = "SELECT members.id, members.name, members.email, members.phone, membership_plans.name as plan_name FROM members LEFT JOIN membership_plans ON members.plan_id = membership_plans.id where 1=1 ";
$resMembers = mysqli_query($conn, $getMembers);
$members = mysqli_fetch_all($resMembers, MYSQLI_ASSOC);

$getMemberPlans = "SELECT * FROM membership_plans";
$resMemberPlans = mysqli_query($conn, $getMemberPlans);
$memberPlans = mysqli_fetch_all($resMemberPlans, MYSQLI_ASSOC);

?>

<div style="left:0; top:0; position:absolute; width:80%; margin-left:280px; padding:20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Add Member</h3>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <form method="post" class="row g-3">

                <?php if ($UpdateDate) : ?>
                    <div class="col-md-4">
                        <label class="form-label">ID</label>
                        <input readonly type="text" name="id" class="form-control"
                            value="<?php echo $UpdateDate['id']; ?>">
                    </div>
                <?php endif; ?>

                <div class="col-md-5">
                    <label class="form-label">Member Name</label>
                    <input type="text" name="member" class="form-control" placeholder="Enter member name" value="<?php echo $UpdateDate['name'] ?? ''; ?>" required>
                </div>

                <div class="col-md-5">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $UpdateDate['email'] ?? ''; ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter your PhoneNumber" value="<?php echo $UpdateDate['phone'] ?? ''; ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Plan</label>
                    <select name="plan" class="form-control" required>
                        <option disabled selected>Select a Plan </option>
                        <?php foreach ($memberPlans as $memberPlan): ?>
                            <?php if ($updateDate): ?>
                                <option value="<?php echo $UpdateDate['plan_id'] ?>" selected><?php echo $memberPlan['name'] ?></option>
                            <?php else: ?>
                                <option value="<?= $memberPlan['id'] ?>"><?= $memberPlan['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <?php if ($UpdateDate) : ?>
                        <button type="submit" name="update" class="me-2 btn btn-primary">Update</button>
                        <a href="members.php" class="btn btn-danger">Cancel</a>
                    <?php else : ?>
                        <button type="submit" name="save" class="btn btn-primary">Add Member</button>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Member Name</th>
                        <th>Member Email</th>
                        <th>Member Phone</th>
                        <th>Plan_id</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($members) > 0) : ?>
                        <?php foreach ($members as $row) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td><?php echo $row['plan_name'] ?></td>
                                <td>
                                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>