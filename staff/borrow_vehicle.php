<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff_name = $_SESSION['full_name'];
$department = $_SESSION['department'];

/*
Get vehicles that are currently available.

Later, we will improve this query so it also checks
reservations for today's date.
*/
$vehicles = mysqli_query($conn, "
    SELECT *
    FROM vehicles
    WHERE vehicle_status = 'Available'
    ORDER BY vehicle_name ASC, plate_number ASC
");

if(!$vehicles){
    die("Vehicle Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Borrow Vehicle</title>

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

<h2 class="page-title">

<i class="fa-solid fa-car-side"></i>

Borrow Vehicle

</h2>

<p class="subtitle">

Borrow an available company vehicle for immediate use today.

</p>

<hr>

<div class="alert alert-info">

<i class="fa-solid fa-circle-info"></i>

<strong>Same-Day Borrowing:</strong>

This form is for vehicles that you want to borrow today.

A pre-borrow inspection video is required before the request
can be submitted for admin approval.

</div>

<form
action="submit_borrow.php"
method="POST"
enctype="multipart/form-data">

<!-- Staff Name -->

<div class="mb-3">

<label class="form-label">
Staff Name
</label>

<input
type="text"
name="staff_name"
class="form-control"
value="<?= htmlspecialchars($staff_name); ?>"
readonly>

</div>

<!-- Department -->

<div class="mb-3">

<label class="form-label">
Department
</label>

<input
type="text"
name="department"
class="form-control"
value="<?= htmlspecialchars($department); ?>"
readonly>

</div>

<!-- Vehicle -->

<div class="mb-3">

<label class="form-label">
Vehicle
</label>

<select
name="vehicle_id"
class="form-select"
required>

<option value="">
Select Available Vehicle
</option>

<?php while($vehicle = mysqli_fetch_assoc($vehicles)){ ?>

<option value="<?= $vehicle['vehicle_id']; ?>">

<?= htmlspecialchars($vehicle['vehicle_name']); ?>

(<?= htmlspecialchars($vehicle['plate_number']); ?>)

</option>

<?php } ?>

</select>

</div>

<!-- Purpose -->

<div class="mb-3">

<label class="form-label">
Purpose
</label>

<textarea
name="purpose"
class="form-control"
rows="4"
placeholder="Example: Deliver documents to Wisma Bapa Malaysia"
required></textarea>

</div>

<!-- Destination -->

<div class="mb-3">

<label class="form-label">
Destination
</label>

<input
type="text"
name="destination"
class="form-control"
placeholder="Example: Wisma Bapa Malaysia"
required>

</div>

<!-- Borrow Date -->

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Borrow Date
</label>

<input
type="date"
name="borrow_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Expected Return
</label>

<input
type="date"
name="expected_return"
class="form-control"
min="<?= date('Y-m-d'); ?>"
value="<?= date('Y-m-d'); ?>"
required>

</div>

</div>

<!-- Pre-Borrow Video -->

<div class="mb-3">

<label class="form-label">

<i class="fa-solid fa-video"></i>

Pre-Borrow Vehicle Inspection Video

</label>

<input
type="file"
name="borrow_video"
class="form-control"
accept="video/*"
required>

<div class="form-text">

Upload a video showing the vehicle condition before taking the vehicle.

</div>

</div>

<!-- Notice -->

<div class="alert alert-warning">

<i class="fa-solid fa-shield-halved"></i>

After submission, your request will be sent to the Admin for approval.

The vehicle will only become <strong>In Use</strong> after approval.

</div>

<!-- Buttons -->

<div class="d-grid gap-2">

<button
type="submit"
class="btn btn-primary p-3">

<i class="fa-solid fa-paper-plane"></i>

Submit Borrow Request

</button>

<a
href="dashboard.php"
class="btn btn-outline-secondary">

<i class="fa-solid fa-house"></i>

Back to Dashboard

</a>

</div>

</form>

</div>

</div>

</body>

</html>
