<?php
include '../db.php';
include '../layout/header.php';
include '../layout/sidebar.php';
?>



<?php

// ==========================

$plan     = $_GET['plan']     ?? '';
$status   = $_GET['status']   ?? '';
$start    = $_GET['start']    ?? '';
$end      = $_GET['end']      ?? '';

// ==========================

$plans = mysqli_fetch_all(
    mysqli_query($conn, "SELECT id, name FROM membership_plans"),
    MYSQLI_ASSOC
);

// ==========================

$sql = "
SELECT 
    members.id,
    members.name,
    members.email,
    members.phone,
    members.joined_at,
    membership_plans.name AS plan_name
FROM members
LEFT JOIN membership_plans ON members.plan_id = membership_plans.id
WHERE 1=1
";

if ($plan !== '') {
    $sql .= " AND members.plan_id = " . (int)$plan;
}

if ($status !== '') {
    $sql .= " AND members.status = '$status'";
}

if ($start !== '') {
    $sql .= " AND members.joined_at >= '$start'";
}

if ($end !== '') {
    $sql .= " AND members.joined_at <= '$end'";
}

// ==========================

$result  = mysqli_query($conn, $sql);
$members = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>



<div style="left: 0; top:0; position:absolute; min-width: 80%; width:auto; margin-left:280px; padding:20px;">

<div class="container-fluid p-3">

    <!-- Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Membership Plan</label>
                    <select name="plan" class="form-control">
                        <option value="">All Plans</option>
                        <?php foreach ($plans as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= ($plan == $p['id']) ? 'selected' : '' ?>>
                                <?= $p['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start" class="form-control" value="<?= $start ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end" class="form-control" value="<?= $end ?>">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary btn-sm">Search</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary">Excel</button>
            <button class="btn btn-outline-secondary">PDF</button>
            <button class="btn btn-outline-secondary">CSV</button>
            <button class="btn btn-outline-secondary">Print</button>
        </div>
        <input type="text" class="form-control form-control-sm w-25" placeholder="Search member...">
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Plan</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($members): ?>
                            <?php foreach ($members as $m): ?>
                                <tr>
                                    <td><?= $m['id'] ?></td>
                                    <td><?= $m['name'] ?></td>
                                    <td><?= $m['email'] ?></td>
                                    <td><?= $m['phone'] ?></td>
                                    <td><?= $m['plan_name'] ?></td>
                                    <td><?= $m['joined_at'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    No members found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>
