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

$booking_id = $_POST['booking_id'];
$vehicle_id = $_POST['vehicle_id'];

$return_condition = mysqli_real_escape_string($conn,$_POST['return_condition']);
$return_remarks   = mysqli_real_escape_string($conn,$_POST['return_remarks']);

$verified_by = $_SESSION['full_name'];
$verified_date = date("Y-m-d H:i:s");

/* Update Booking */

mysqli_query($conn,"
UPDATE bookings
SET

status='Completed',
return_condition='$return_condition',
return_remarks='$return_remarks',
verified_by='$verified_by',
verified_date='$verified_date'

WHERE booking_id='$booking_id'
");

/* Update Vehicle Status */

if($return_condition=="Major Damage"){

    mysqli_query($conn,"
    UPDATE vehicles
    SET vehicle_status='Maintenance'
    WHERE vehicle_id='$vehicle_id'
    ");

}else{

    mysqli_query($conn,"
    UPDATE vehicles
    SET vehicle_status='Available'
    WHERE vehicle_id='$vehicle_id'
    ");

}

echo "<script>

alert('Return verified successfully.');

window.location='return_verification.php';

</script>";

?>
