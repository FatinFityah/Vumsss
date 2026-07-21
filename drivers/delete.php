<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

if(!isset($_GET['id'])){

    header("Location:index.php");
    exit();

}

$driver_id = intval($_GET['id']);

$check = mysqli_query($conn,"
SELECT *
FROM drivers
WHERE driver_id='$driver_id'
");

if(mysqli_num_rows($check)==0){

    echo "<script>
            alert('Driver not found.');
            window.location='index.php';
          </script>";
    exit();

}

$delete = mysqli_query($conn,"
DELETE FROM drivers
WHERE driver_id='$driver_id'
");

if($delete){

    echo "<script>
            alert('Driver deleted successfully!');
            window.location='index.php';
          </script>";

}else{

    echo "<script>
            alert('Failed to delete driver!');
            window.location='index.php';
          </script>";

}
?>
