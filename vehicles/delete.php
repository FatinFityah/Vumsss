<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$id = $_GET['id'];

/* Get photo */

$get = mysqli_query($conn,"
SELECT vehicle_photo
FROM vehicles
WHERE vehicle_id='$id'
");

$row = mysqli_fetch_assoc($get);

if($row['vehicle_photo']!=""){

    $file="../../uploads/".$row['vehicle_photo'];

    if(file_exists($file)){
        unlink($file);
    }

}

/* Delete vehicle */

mysqli_query($conn,"
DELETE FROM vehicles
WHERE vehicle_id='$id'
");

echo "<script>

alert('Vehicle deleted successfully.');

window.location='index.php';

</script>";

?>
