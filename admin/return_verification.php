<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role']!="Admin"){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$sql = mysqli_query($conn,"
SELECT
b.*,
v.vehicle_name,
v.plate_number
FROM bookings b
LEFT JOIN vehicles v
ON b.vehicle_id = v.vehicle_id
WHERE b.status='Returned'
ORDER BY b.return_date DESC
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Return Verification</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>
.video-btn{min-width:120px}
.table td{vertical-align:middle}
</style>

</head>
<body>

<div class="container-fluid">
<div class="row">

<?php include("includes/sidebar.php"); ?>

<div class="col-lg-10 p-4">

<h2 class="page-title">🚗 Return Verification</h2>
<p class="subtitle">Verify returned company vehicles.</p>

<hr>

<div class="card-box">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="text-center">

<tr>

<th style="width:28%">Vehicle</th>

<th style="width:18%">Borrower</th>

<th style="width:14%">Return Video</th>

<th style="width:15%">Condition</th>

<th style="width:18%">Remarks</th>

<th style="width:7%">Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($sql)){ ?>

<form action="verify_return.php" method="POST">

<input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
<input type="hidden" name="vehicle_id" value="<?= $row['vehicle_id']; ?>">

<tr class="align-middle">

<td>

<strong><?= $row['vehicle_name']; ?></strong>

<br>

<span class="text-muted"><?= $row['plate_number']; ?></span>

</td>

<td>

<?= $row['staff_name']; ?>

</td>

<td class="text-center">

<?php if($row['return_video']!=""){ ?>

<a href="../uploads/<?= $row['return_video']; ?>"
target="_blank"
class="btn btn-primary btn-sm">

<i class="fa-solid fa-play"></i>

Watch

</a>

<?php }else{ ?>

<span class="badge bg-secondary">

No Video

</span>

<?php } ?>

</td>

<td>

<select
name="return_condition"
class="form-select form-select-sm"
required>

<option value="">Choose</option>

<option>Good</option>

<option>Minor Damage</option>

<option>Major Damage</option>

</select>

</td>

<td>

<textarea
name="return_remarks"
class="form-control form-control-sm"
rows="2"
placeholder="Remarks..."></textarea>

</td>

<td class="text-center">

<button
class="btn btn-success btn-sm">

Verify

</button>

</td>

</tr>

</form>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
