<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff = $_SESSION['full_name'];

$result = mysqli_query($conn,"
SELECT
bookings.*,
vehicles.vehicle_name,
vehicles.plate_number
FROM bookings
JOIN vehicles
ON bookings.vehicle_id=vehicles.vehicle_id
WHERE bookings.staff_name='$staff'
ORDER BY booking_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Reservations</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body style="background:#F8FAFC;">

<div class="container mt-5">

<div class="card-box">

<h2 class="page-title">

📋 My Reservations

</h2>

<p class="subtitle">

Track your reservation status.

</p>

<hr>

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>Vehicle</th>

<th>Borrow</th>

<th>Return</th>

<th>Reservation</th>

<th>Approval</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?= $row['booking_id']; ?>

</td>

<td>

<strong>

<?= $row['vehicle_name']; ?>

</strong>

<br>

<small>

<?= $row['plate_number']; ?>

</small>

</td>

<td>

<?= $row['borrow_date']; ?>

</td>

<td>

<?= $row['expected_return']; ?>

</td>

<td>

<?php

switch($row['status']){

case "Reserved":

echo '<span class="badge bg-warning text-dark">Reserved</span>';

break;

case "Ready for Collection":

echo '<span class="badge bg-success">Ready</span>';

break;

case "In Use":

echo '<span class="badge bg-primary">In Use</span>';

break;

case "Returned":

echo '<span class="badge bg-secondary">Returned</span>';

break;

default:

echo '<span class="badge bg-dark">'.$row['status'].'</span>';

}

?>

</td>

<td>

<?php

switch($row['approval_status']){

case "Pending Video":

echo '<span class="badge bg-info text-dark">Pending Video</span>';

break;

case "Pending Approval":

echo '<span class="badge bg-warning text-dark">Pending Approval</span>';

break;

case "Approved":

echo '<span class="badge bg-success">Approved</span>';

break;

case "Rejected":

echo '<span class="badge bg-danger">Rejected</span>';

break;

default:

echo '<span class="badge bg-secondary">'.$row['approval_status'].'</span>';

}

?>

</td>

<td>

<?php

if($row['approval_status']=="Pending Video"){

?>

<a
href="upload_video.php?id=<?= $row['booking_id']; ?>"
class="btn btn-primary btn-sm">

<i class="fa-solid fa-video"></i>

Upload Video

</a>

<?php

}else{

echo "-";

}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="text-center">

No reservations found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<hr>

<div class="d-flex justify-content-between">

<a href="dashboard.php" class="btn btn-success">

🏠 Dashboard

</a>

<a href="../logout.php" class="btn btn-danger">

🚪 Logout

</a>

</div>

</div>

</div>

</body>

</html>
