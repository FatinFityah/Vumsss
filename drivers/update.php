<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: index.php");
    exit();
}

$driver_id = intval($_POST['driver_id']);

$driver_name = mysqli_real_escape_string($conn, trim($_POST['driver_name']));
$department = mysqli_real_escape_string($conn, trim($_POST['department']));
$phone_number = mysqli_real_escape_string($conn, trim($_POST['phone_number']));
$status = mysqli_real_escape_string($conn, trim($_POST['status']));
$remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));

// Check if another driver already uses the same name
$check = mysqli_query($conn,"
SELECT driver_id
FROM drivers
WHERE driver_name='$driver_name'
AND driver_id != '$driver_id'
");

if(mysqli_num_rows($check) > 0){

    echo "<script>
            alert('Driver name already exists.');
            history.back();
          </script>";
    exit();

}

$sql = "UPDATE drivers SET

driver_name='$driver_name',
department='$department',
phone_number='$phone_number',
status='$status',
remarks='$remarks'

WHERE driver_id='$driver_id'";

if(mysqli_query($conn,$sql)){

    echo "<script>
            alert('Driver updated successfully!');
            window.location='index.php';
          </script>";

}else{

    echo "<script>
            alert('Failed to update driver!');
            history.back();
          </script>";

}
?>
