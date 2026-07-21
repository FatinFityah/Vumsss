<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$result = mysqli_query($conn,"
SELECT
bookings.booking_id,
bookings.staff_name,
bookings.department,
bookings.purpose,
bookings.destination,
bookings.borrow_date,
bookings.expected_return,
bookings.status,
vehicles.vehicle_name,
vehicles.plate_number

FROM bookings

INNER JOIN vehicles
ON bookings.vehicle_id = vehicles.vehicle_id

ORDER BY bookings.booking_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Vehicle Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body style="background:#F6FBF6;">

<div class="container mt-4">

<h2 class="text-success">

📄 Vehicle Booking Report

</h2>

<p class="text-muted">

TEGAS Smart Vehicle Usage Management System

</p>

<hr>

<div class="mb-3">

<button onclick="window.print()" class="btn btn-success">

🖨 Print Report

</button>

<a href="../dashboard.php" class="btn btn-secondary">

← Dashboard

</a>

</div>

<table class="table table-bordered table-hover">

<thead class="table-success">

<tr>

<th>ID</th>

<th>Staff</th>

<th>Department</th>

<th>Vehicle</th>

<th>Purpose</th>

<th>Destination</th>

<th>Borrow Date</th>

<th>Expected Return</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= $row['booking_id']; ?></td>

<td><?= $row['staff_name']; ?></td>

<td><?= $row['department']; ?></td>

<td>

<?= $row['vehicle_name']; ?>

<br>

<small>

<?= $row['plate_number']; ?>

</small>

</td>

<td><?= $row['purpose']; ?></td>

<td><?= $row['destination']; ?></td>

<td><?= $row['borrow_date']; ?></td>

<td><?= $row['expected_return']; ?></td>

<td>

<?php

if($row['status']=="In Use"){

echo '<span class="badge bg-warning text-dark">In Use</span>';

}else{

echo '<span class="badge bg-success">Returned</span>';

}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="9" class="text-center">

No record found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</body>

</html>
