<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Add Vehicle</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container mt-5">

<div class="card-box">

<h2 class="page-title">

➕ Add Vehicle

</h2>

<hr>

<form action="insert.php" method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>Vehicle Name</label>

<input
type="text"
name="vehicle_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Plate Number</label>

<input
type="text"
name="plate_number"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Brand</label>

<input
type="text"
name="brand"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Model</label>

<input
type="text"
name="model"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Colour</label>

<input
type="text"
name="colour"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Capacity</label>

<input
type="number"
name="capacity"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Roadtax Expiry</label>

<input
type="date"
name="roadtax_expiry"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Insurance Expiry</label>

<input
type="date"
name="insurance_expiry"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Vehicle Photo</label>

<input
type="file"
name="photo"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select
name="vehicle_status"
class="form-select">

<option>Available</option>

<option>Maintenance</option>

</select>

</div>

</div>

<button class="btn btn-success">

Save Vehicle

</button>

<a href="index.php" class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</body>

</html>
