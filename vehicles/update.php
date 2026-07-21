<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$id = $_POST['vehicle_id'];

$vehicle_name      = mysqli_real_escape_string($conn,$_POST['vehicle_name']);
$plate_number      = mysqli_real_escape_string($conn,$_POST['plate_number']);
$brand             = mysqli_real_escape_string($conn,$_POST['brand']);
$model             = mysqli_real_escape_string($conn,$_POST['model']);
$colour            = mysqli_real_escape_string($conn,$_POST['colour']);
$capacity          = mysqli_real_escape_string($conn,$_POST['capacity']);
$roadtax_expiry    = $_POST['roadtax_expiry'];
$insurance_expiry  = $_POST['insurance_expiry'];
$vehicle_status    = $_POST['vehicle_status'];

if($_FILES['photo']['name']!=""){

    $photo=time()."_".$_FILES['photo']['name'];

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "../../uploads/".$photo
    );

    $sql="UPDATE vehicles SET

    vehicle_name='$vehicle_name',
    plate_number='$plate_number',
    brand='$brand',
    model='$model',
    colour='$colour',
    capacity='$capacity',
    roadtax_expiry='$roadtax_expiry',
    insurance_expiry='$insurance_expiry',
    vehicle_photo='$photo',
    vehicle_status='$vehicle_status'

    WHERE vehicle_id='$id'";

}else{

    $sql="UPDATE vehicles SET

    vehicle_name='$vehicle_name',
    plate_number='$plate_number',
    brand='$brand',
    model='$model',
    colour='$colour',
    capacity='$capacity',
    roadtax_expiry='$roadtax_expiry',
    insurance_expiry='$insurance_expiry',
    vehicle_status='$vehicle_status'

    WHERE vehicle_id='$id'";

}

if(mysqli_query($conn,$sql)){

    echo "<script>

    alert('Vehicle updated successfully.');

    window.location='index.php';

    </script>";

}else{

    echo mysqli_error($conn);

}
?>
