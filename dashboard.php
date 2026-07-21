<?php
session_start();
if(!isset($_SESSION['user_id'])){header("Location: ../login.php");exit();}
if($_SESSION['role']!="Super Admin"){header("Location: ../login.php");exit();}
include("../config/database.php");

$totalUsers=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM users"))['total'];
$totalVehicles=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM vehicles"))['total'];
$availableVehicles=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='Available'"))['total'];
$inUseVehicles=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='In Use'"))['total'];


$currentBookings = mysqli_query($conn,"
SELECT b.staff_name,b.borrow_date,v.vehicle_name,v.plate_number
FROM bookings b
JOIN vehicles v ON b.vehicle_id=v.vehicle_id
WHERE b.status='In Use'
ORDER BY b.borrow_date DESC");

?>

<!DOCTYPE html>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Super Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>
<div class="container-fluid">
<div class="row">
<?php include("sidebar.php"); ?>
<div class="col-lg-10 p-4">

<h2 class="page-title">👋 Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?></h2>
<p class="subtitle">Fleet Management Control Centre</p>
<hr>

<div class="row g-4 mb-4">
<div class="col-md-3"><div class="stat-card bg-soft-blue"><div class="dashboard-icon icon-blue"><i class="fa-solid fa-users"></i></div><h6>Total Users</h6><h1><?= $totalUsers ?></h1></div></div>
<div class="col-md-3"><div class="stat-card bg-soft-green"><div class="dashboard-icon icon-green"><i class="fa-solid fa-car"></i></div><h6>Total Vehicles</h6><h1><?= $totalVehicles ?></h1></div></div>
<div class="col-md-3"><div class="stat-card bg-soft-yellow"><div class="dashboard-icon icon-yellow"><i class="fa-solid fa-circle-check"></i></div><h6>Available</h6><h1><?= $availableVehicles ?></h1></div></div>
<div class="col-md-3"><div class="stat-card bg-soft-red"><div class="dashboard-icon icon-red"><i class="fa-solid fa-road"></i></div><h6>Vehicles In Use</h6><h1><?= $inUseVehicles ?></h1></div></div>
</div>

<div class="card-box">
<h4 class="mb-3">🚗 Current Vehicle Usage</h4>
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead><tr><th>Plate Number</th><th>Vehicle</th><th>Borrower</th><th>Borrow Date</th><th>Status</th></tr></thead>
<tbody>

<?php if (mysqli_num_rows($currentBookings) > 0) { ?>

    <?php while ($r = mysqli_fetch_assoc($currentBookings)) { ?>

    <tr>
        <td><?= htmlspecialchars($r['plate_number']); ?></td>
        <td><?= htmlspecialchars($r['vehicle_name']); ?></td>
        <td><?= htmlspecialchars($r['staff_name']); ?></td>
        <td><?= htmlspecialchars($r['borrow_date']); ?></td>
        <td>
            <span class="badge bg-warning text-dark">
                In Use
            </span>
        </td>
    </tr>

    <?php } ?>

<?php } else { ?>

    <tr>
        <td colspan="5" class="text-center">
            No vehicles are currently in use.
        </td>
    </tr>

<?php } ?>

</tbody>
</table>
</div>
</div>

<div class="row g-4 mt-4">
<div class="col-md-3"><a href="users/index.php" class="quick-card"><i class="fa-solid fa-users"></i><h5>Manage Users</h5><p>User accounts</p></a></div>
<div class="col-md-3"><a href="vehicles/index.php" class="quick-card"><i class="fa-solid fa-car"></i><h5>Vehicles</h5><p>Manage fleet</p></a></div>
<div class="col-md-3"><a href="../reports/index.php" class="quick-card"><i class="fa-solid fa-chart-column"></i><h5>Reports</h5><p>View reports</p></a></div>
<div class="col-md-3"><a href="../logout.php" class="quick-card"><i class="fa-solid fa-right-from-bracket"></i><h5>Logout</h5><p>Sign out</p></a></div>
</div>

</div></div></div>
</body></html>
