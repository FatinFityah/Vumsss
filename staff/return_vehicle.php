<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff_name = $_SESSION['full_name'];

$sql = mysqli_query($conn,"
SELECT
b.*,
v.vehicle_name,
v.plate_number
FROM bookings b
JOIN vehicles v
ON b.vehicle_id = v.vehicle_id
WHERE b.staff_name = '$staff_name'
AND b.status = 'In Use'
ORDER BY b.booking_id DESC
");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Return Vehicle</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-5">

<h2 class="page-title">

🚗 Return Vehicle

</h2>

<hr>

<?php while($row=mysqli_fetch_assoc($sql)){ ?>

<div class="card-box mb-4">

<form
action="submit_return.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="booking_id"
value="<?= $row['booking_id']; ?>">

<input
type="hidden"
name="vehicle_id"
value="<?= $row['vehicle_id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label>Vehicle</label>

<input
type="text"
class="form-control"
value="<?= $row['vehicle_name']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Plate Number</label>

<input
type="text"
class="form-control"
value="<?= $row['plate_number']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Borrow Date</label>

<input
type="date"
class="form-control"
value="<?= $row['borrow_date']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Return Date</label>

<input
type="date"
name="return_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Current Mileage</label>

<input
type="number"
name="mileage"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Return Video</label>

<input
type="file"
name="return_video"
class="form-control"
accept="video/*"
required>

</div>

<div class="col-12 mb-3">

<label>Remarks</label>

<textarea
name="remarks"
class="form-control"
rows="4"></textarea>

</div>

</div>

<button
class="btn btn-success">

Submit Return

</button>

</form>

</div>

<?php } ?>

</div>

</body>

</html>
