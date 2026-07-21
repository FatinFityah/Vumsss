<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$id = $_GET['id'];

$sql = mysqli_query($conn,"
SELECT *
FROM vehicles
WHERE vehicle_id='$id'
");

$row = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit Vehicle</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container mt-5">

<div class="card-box">

<h2 class="page-title">

✏ Edit Vehicle

</h2>

<hr>

<form action="update.php" method="POST" enctype="multipart/form-data">

<input
type="hidden"
name="vehicle_id"
value="<?= $row['vehicle_id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label>Vehicle Name</label>

<input
type="text"
name="vehicle_name"
class="form-control"
value="<?= $row['vehicle_name']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Plate Number</label>

<input
type="text"
name="plate_number"
class="form-control"
value="<?= $row['plate_number']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Brand</label>

<input
type="text"
name="brand"
class="form-control"
value="<?= $row['brand']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Model</label>

<input
type="text"
name="model"
class="form-control"
value="<?= $row['model']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Colour</label>

<input
type="text"
name="colour"
class="form-control"
value="<?= $row['colour']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Capacity</label>

<input
type="number"
name="capacity"
class="form-control"
value="<?= $row['capacity']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Roadtax Expiry</label>

<input
type="date"
name="roadtax_expiry"
class="form-control"
value="<?= $row['roadtax_expiry']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Insurance Expiry</label>

<input
type="date"
name="insurance_expiry"
class="form-control"
value="<?= $row['insurance_expiry']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select
name="vehicle_status"
class="form-select">

<option <?= $row['vehicle_status']=="Available"?"selected":""; ?>>
Available
</option>

<option <?= $row['vehicle_status']=="Maintenance"?"selected":""; ?>>
Maintenance
</option>

<option <?= $row['vehicle_status']=="Reserved"?"selected":""; ?>>
Reserved
</option>

<option <?= $row['vehicle_status']=="In Use"?"selected":""; ?>>
In Use
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>New Photo (Optional)</label>

<input
type="file"
name="photo"
class="form-control">

</div>

</div>

<button class="btn btn-success">

Update Vehicle

</button>

<a href="index.php" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</body>

</html>
