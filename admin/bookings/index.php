<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$sql = "SELECT
            bookings.*,
            vehicles.vehicle_name,
            vehicles.plate_number
        FROM bookings
        JOIN vehicles
        ON bookings.vehicle_id = vehicles.vehicle_id
        ORDER BY bookings.booking_id DESC";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body style="background:#F6FBF6;">

<div class="container mt-5">

<div class="card-box">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>📅 Booking Requests</h2>

<p class="text-muted">
Approve or reject vehicle booking requests.
</p>

</div>

<a href="../dashboard.php" class="btn btn-secondary">
Dashboard
</a>

</div>

<hr>

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>

<th>Staff</th>

<th>Department</th>

<th>Vehicle</th>

<th>Purpose</th>

<th>Borrow</th>

<th>Return</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['booking_id']; ?></td>

<td><?= $row['staff_name']; ?></td>

<td><?= $row['department']; ?></td>

<td>

<?= $row['vehicle_name']; ?>

<br>

<small><?= $row['plate_number']; ?></small>

</td>

<td><?= $row['purpose']; ?></td>

<td><?= $row['borrow_date']; ?></td>

<td><?= $row['expected_return']; ?></td>

<td>

<?php

if($row['status']=="Pending"){

echo '<span class="badge bg-warning text-dark">Pending</span>';

}elseif($row['status']=="Approved"){

echo '<span class="badge bg-success">Approved</span>';

}elseif($row['status']=="Rejected"){

echo '<span class="badge bg-danger">Rejected</span>';

}else{

echo '<span class="badge bg-primary">Returned</span>';

}

?>

</td>

<td>

<?php

if($row['status']=="Pending"){

?>

<a
href="approve.php?id=<?= $row['booking_id']; ?>"
class="btn btn-success btn-sm">

Approve

</a>

<a
href="reject.php?id=<?= $row['booking_id']; ?>"
class="btn btn-danger btn-sm">

Reject

</a>

<?php
}else{

echo "-";

}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>

</html>
