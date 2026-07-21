<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$vehicles = mysqli_query($conn,"
SELECT *
FROM vehicles
ORDER BY vehicle_name ASC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Vehicle Calendar</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-lg-2 sidebar">

<div class="logo text-center mt-4">

<i class="fa-solid fa-car-side fa-3x"></i>

<h3 class="mt-3">

TEGAS Fleet

</h3>

<p>Smart Fleet Management</p>

</div>

<hr>

<a href="dashboard.php">
<i class="fa-solid fa-house"></i>
Dashboard
</a>

<a href="calendar.php" class="active">
<i class="fa-solid fa-calendar"></i>
Calendar
</a>

<a href="book_vehicle.php">
<i class="fa-solid fa-car"></i>
Reserve Vehicle
</a>

<a href="my_bookings.php">
<i class="fa-solid fa-list"></i>
My Reservation
</a>

<a href="return_vehicle.php">
<i class="fa-solid fa-arrow-rotate-left"></i>
Return Vehicle
</a>

<a href="../logout.php">
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>

</div>

<!-- Content -->

<div class="col-lg-10 p-4">

<h2 class="page-title">

📅 Vehicle Availability Calendar

</h2>

<p class="subtitle">

Select your reservation date first.

</p>

<hr>

<div class="card-box mb-4">

<div class="row">

<div class="col-md-4">

<label class="form-label">

Borrow Date

</label>

<input
type="date"
id="borrow_date"
class="form-control">

</div>

<div class="col-md-4">

<label class="form-label">

Return Date

</label>

<input
type="date"
id="return_date"
class="form-control">

</div>

<div class="col-md-4 d-flex align-items-end">

<button
class="btn btn-primary w-100">

<i class="fa-solid fa-magnifying-glass"></i>

Check Availability

</button>

</div>

</div>

</div>

<div class="row">

<?php while($vehicle=mysqli_fetch_assoc($vehicles)){ ?>

<div class="col-md-4 mb-4">

<div class="dashboard-card">

<h4>

🚗

<?= $vehicle['vehicle_name']; ?>

</h4>

<p>

<?= $vehicle['plate_number']; ?>

</p>

<hr>

<?php

if($vehicle['vehicle_status']=="Available"){

echo "<span class='badge bg-success'>Available</span>";

}else{

echo "<span class='badge bg-danger'>In Use</span>";

}

?>

<br><br>

<a
href="book_vehicle.php?vehicle_id=<?= $vehicle['vehicle_id']; ?>"
class="btn btn-primary w-100">

Reserve Vehicle

</a>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>

</html>
