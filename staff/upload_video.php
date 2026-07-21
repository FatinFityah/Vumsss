<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$id=$_GET['id'];

$get=mysqli_query($conn,"
SELECT
bookings.*,
vehicles.vehicle_name,
vehicles.plate_number
FROM bookings
JOIN vehicles
ON bookings.vehicle_id=vehicles.vehicle_id
WHERE booking_id='$id'
");

$row=mysqli_fetch_assoc($get);

$today=date("Y-m-d");

$allowUpload=false;

$borrow=strtotime($row['borrow_date']);
$todayTime=strtotime($today);

$diff=($borrow-$todayTime)/86400;

if($diff<=1 && $diff>=0){
    $allowUpload=true;
}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Upload Inspection Video</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body style="background:#F8FAFC;">

<div class="container mt-5">

<div class="card-box">

<h2>

🎥 Upload Inspection Video

</h2>

<hr>

<p>

<strong>Vehicle :</strong>

<?= $row['vehicle_name']; ?>

</p>

<p>

<strong>Plate Number :</strong>

<?= $row['plate_number']; ?>

</p>

<p>

<strong>Borrow Date :</strong>

<?= $row['borrow_date']; ?>

</p>

<hr>

<?php

if($allowUpload){

?>

<form
action="submit_video.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="booking_id"
value="<?= $id; ?>">

<label>

Video

</label>

<input
type="file"
name="video"
class="form-control"
accept="video/*"
required>

<br>

<button
class="btn btn-primary">

Upload Video

</button>

</form>

<?php

}else{

?>

<div class="alert alert-warning">

You can upload the inspection video

24 hours before the reservation date.

</div>

<?php

}

?>

</div>

</div>

</body>

</html>
