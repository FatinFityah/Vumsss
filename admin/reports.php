<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: ../login.php"); exit(); }
if($_SESSION['role']!='Admin'){ header("Location: ../login.php"); exit(); }
include("../config/database.php");
function total($c,$s){$q=mysqli_query($c,$s); if(!$q)return 0; $r=mysqli_fetch_assoc($q); return $r['total']??0;}
$totalVehicles=total($conn,"SELECT COUNT(*) total FROM vehicles");
$available=total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='Available'");
$inUse=total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='In Use'");
$maintenance=total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='Maintenance'");
$completed=total($conn,"SELECT COUNT(*) total FROM bookings WHERE status='Completed'");
$pending=total($conn,"SELECT COUNT(*) total FROM bookings WHERE approval_status='Pending Approval'");
$staff=mysqli_query($conn,"SELECT staff_name,department,COUNT(*) total FROM bookings GROUP BY staff_name,department ORDER BY total DESC");
$vehicle=mysqli_query($conn,"SELECT vehicle_name,plate_number,vehicle_status FROM vehicles ORDER BY vehicle_name");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Reports</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link rel='stylesheet' href='../assets/css/style.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css'>
</head><body>
<div class='container-fluid'><div class='row'>
<?php include("includes/sidebar.php"); ?>
<div class='col-lg-10 p-4'>
<div class='d-flex justify-content-between mb-4'><div><h2 class='page-title'>📊 Reports</h2><p class='subtitle'>Fleet Management Summary</p></div><button class='btn btn-primary' onclick='window.print()'><i class='fa-solid fa-print'></i> Print</button></div>
<div class='row g-3 mb-4'>
<div class='col'><div class='stat-card bg-soft-blue'><h6>Total Vehicles</h6><h1><?= $totalVehicles ?></h1></div></div>
<div class='col'><div class='stat-card bg-soft-green'><h6>Available</h6><h1><?= $available ?></h1></div></div>
<div class='col'><div class='stat-card bg-soft-yellow'><h6>In Use</h6><h1><?= $inUse ?></h1></div></div>
<div class='col'><div class='stat-card bg-soft-red'><h6>Maintenance</h6><h1><?= $maintenance ?></h1></div></div>
<div class='col'><div class='stat-card bg-soft-orange'><h6>Completed</h6><h1><?= $completed ?></h1></div></div>
<div class='col'><div class='stat-card bg-soft-purple'><h6>Pending</h6><h1><?= $pending ?></h1></div></div>
</div>
<div class='card-box mb-4'><h4>Staff Usage Report</h4><div class='table-responsive'><table class='table table-hover'><thead><tr><th>Staff</th><th>Department</th><th>Total Borrow</th></tr></thead><tbody><?php while($r=mysqli_fetch_assoc($staff)){ ?><tr><td><?= htmlspecialchars($r['staff_name']) ?></td><td><?= htmlspecialchars($r['department']) ?></td><td><?= $r['total'] ?></td></tr><?php } ?></tbody></table></div></div>
<div class='card-box'><h4>Vehicle Status Report</h4><div class='table-responsive'><table class='table table-hover'><thead><tr><th>Vehicle</th><th>Plate</th><th>Status</th></tr></thead><tbody><?php while($v=mysqli_fetch_assoc($vehicle)){ ?><tr><td><?= htmlspecialchars($v['vehicle_name']) ?></td><td><?= htmlspecialchars($v['plate_number']) ?></td><td><?= htmlspecialchars($v['vehicle_status']) ?></td></tr><?php } ?></tbody></table></div></div>
</div></div></div></body></html>
