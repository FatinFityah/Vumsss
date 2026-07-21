<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

/*
Show same-day borrow requests
that are waiting for Admin approval.
*/
$sql = "
SELECT
    bookings.*,
    vehicles.vehicle_name,
    vehicles.plate_number,
    vehicles.colour
FROM bookings
JOIN vehicles
    ON bookings.vehicle_id = vehicles.vehicle_id
WHERE bookings.approval_status = 'Pending Approval'
ORDER BY bookings.borrow_date ASC,
         bookings.booking_id DESC
";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Approval Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Borrow Request Approval</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link
rel="stylesheet"
href="../assets/css/style.css">

</head>

<body style="background:#F8FAFC;">

<div class="container mt-5 mb-5">

<div class="card-box">

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

<div>

<h2 class="page-title">

<i class="fa-solid fa-clipboard-check"></i>

Borrow Request Approval

</h2>

<p class="subtitle">

Review the pre-borrow inspection video before approving vehicle use.

</p>

</div>

<a
href="dashboard.php"
class="btn btn-outline-secondary">

<i class="fa-solid fa-house"></i>

Dashboard

</a>

</div>

<hr>

<?php if(mysqli_num_rows($result) > 0){ ?>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Borrower</th>

<th>Vehicle</th>

<th>Trip Details</th>

<th>Borrow Date</th>

<th>Return Date</th>

<th>Inspection Video</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

<strong>
<?= htmlspecialchars($row['staff_name']); ?>
</strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['department']); ?>

</small>

</td>

<td>

<strong>

<?= htmlspecialchars($row['vehicle_name']); ?>

</strong>

<br>

<small>

<?= htmlspecialchars($row['plate_number']); ?>

</small>

<?php if(!empty($row['vehicle_color'])){ ?>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['vehicle_color']); ?>

</small>

<?php } ?>

</td>

<td>

<strong>Purpose:</strong>

<br>

<?= htmlspecialchars($row['purpose']); ?>

<br><br>

<strong>Destination:</strong>

<br>

<?= htmlspecialchars($row['destination']); ?>

</td>

<td>

<?= htmlspecialchars($row['borrow_date']); ?>

</td>

<td>

<?= htmlspecialchars($row['expected_return']); ?>

</td>

<td>

<?php if(!empty($row['borrow_video'])){ ?>

<video
width="220"
controls
preload="metadata"
class="rounded border">

<source
src="../staff/uploads/<?= rawurlencode($row['borrow_video']); ?>">

Your browser does not support video playback.

</video>

<br>

<a
href="../staff/uploads/<?= rawurlencode($row['borrow_video']); ?>"
target="_blank"
class="btn btn-primary btn-sm mt-2">

<i class="fa-solid fa-play"></i>

Open Video

</a>

<?php }else{ ?>

<span class="badge bg-danger">

<i class="fa-solid fa-triangle-exclamation"></i>

No Video

</span>

<?php } ?>

</td>

<td>

<?php if(!empty($row['borrow_video'])){ ?>

<a
href="approve.php?id=<?= $row['booking_id']; ?>"
class="btn btn-success btn-sm mb-2"
onclick="return confirm('Approve this borrow request? The vehicle will be marked as In Use.');">

<i class="fa-solid fa-check"></i>

Approve

</a>

<br>

<a
href="reject.php?id=<?= $row['booking_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Reject this borrow request?');">

<i class="fa-solid fa-xmark"></i>

Reject

</a>

<?php }else{ ?>

<button
class="btn btn-secondary btn-sm"
disabled>

Cannot Approve

</button>

<br>

<small class="text-danger">

Video required

</small>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php }else{ ?>

<div class="text-center py-5">

<i
class="fa-solid fa-circle-check fa-4x"
style="color:#9ED8C3;">
</i>

<h4 class="mt-4">

No Pending Borrow Requests

</h4>

<p class="text-muted">

There are currently no borrow requests waiting for approval.

</p>

</div>

<?php } ?>

</div>

</div>

</body>

</html>
