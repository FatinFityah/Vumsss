<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff_name = $_SESSION['full_name'];
$department = $_SESSION['department'];

/* Get all vehicles */
$vehicles = mysqli_query($conn, "
    SELECT *
    FROM vehicles
    ORDER BY vehicle_name ASC, plate_number ASC
");

if(!$vehicles){
    die("Vehicle Query Error: " . mysqli_error($conn));
}

/* Selected vehicle from calendar, if any */
$selected_vehicle_id = isset($_GET['vehicle_id'])
    ? intval($_GET['vehicle_id'])
    : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Reserve Vehicle</title>

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

<i class="fa-solid fa-calendar-check"></i>

Reserve Vehicle

</h2>

<p class="subtitle">

Reserve a company vehicle for your upcoming trip.

</p>

<hr>

<div class="alert alert-info">

<i class="fa-solid fa-circle-info"></i>

<strong>How it works:</strong>

Reserve your vehicle for a future date.

The pre-borrow vehicle inspection video is not required during
reservation.

</div>

<form
action="submit_booking.php"
method="POST">

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

Select Vehicle

</option>

<?php while($vehicle = mysqli_fetch_assoc($vehicles)){ ?>

<option
value="<?= $vehicle['vehicle_id']; ?>"
<?= ($selected_vehicle_id == $vehicle['vehicle_id'])
    ? 'selected'
    : ''; ?>>

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

<!-- Dates -->

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Borrow Date

</label>

<input
type="date"
name="borrow_date"
id="borrow_date"
class="form-control"
min="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Expected Return

</label>

<input
type="date"
name="expected_return"
id="expected_return"
class="form-control"
min="<?= date('Y-m-d'); ?>"
required>

</div>

</div>

<!-- Video Notice -->

<div class="alert alert-warning mt-2">

<i class="fa-solid fa-video"></i>

<strong>Pre-Borrow Inspection Video</strong>

<br>

No video is required during reservation.

The inspection video will be uploaded later when the vehicle is
actually being borrowed or collected.

</div>

<!-- Buttons -->

<div class="d-grid gap-2">

<button
type="submit"
class="btn btn-primary p-3">

<i class="fa-solid fa-calendar-check"></i>

Submit Reservation

</button>

<a
href="calendar.php"
class="btn btn-outline-secondary">

<i class="fa-solid fa-calendar"></i>

Back to Calendar

</a>

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

<script>

const borrowDate =
document.getElementById("borrow_date");

const returnDate =
document.getElementById("expected_return");

borrowDate.addEventListener("change", function(){

    returnDate.min = this.value;

    if(
        returnDate.value &&
        returnDate.value < this.value
    ){
        returnDate.value = this.value;
    }

});

</script>

</body>

</html>
