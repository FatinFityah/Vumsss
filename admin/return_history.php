<?php
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
WHERE b.status='Completed'
ORDER BY b.approval_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Return History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<?php include("includes/sidebar.php"); ?>

<div class="col-lg-10 p-4">

<h2 class="page-title">

📋 Return History

</h2>

<p class="subtitle">

Verified vehicle returns.

</p>

<hr>

<div class="card-box">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Vehicle</th>

<th>Borrower</th>

<th>Condition</th>

<th>Verified By</th>

<th>Verified Date</th>

<th>Remarks</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($sql)){ ?>

<tr>

<td>

<strong>

<?= htmlspecialchars($row['vehicle_name']); ?>

</strong>

<br>

<small>

<?= htmlspecialchars($row['plate_number']); ?>

</small>

</td>

<td>

<?= htmlspecialchars($row['staff_name']); ?>

</td>

<td>

<?php

if($row['return_condition']=="Good"){

echo '<span class="badge bg-success">Good</span>';

}

elseif($row['return_condition']=="Minor Damage"){

echo '<span class="badge bg-warning text-dark">Minor Damage</span>';

}

else{

echo '<span class="badge bg-danger">Major Damage</span>';

}

?>

</td>

<td>

<?= htmlspecialchars($row['approval_by'] ?? '-'); ?>

</td>

<td>

<?= htmlspecialchars($row['approval_date'] ?? '-'); ?>

</td>

<td>

<?= htmlspecialchars($row['remarks'] ?? '-'); ?>

</td>

</tr>

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
