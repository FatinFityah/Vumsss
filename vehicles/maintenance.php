<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE vehicles
SET
vehicle_status='Available',
maintenance_reason=NULL,
workshop=NULL,
expected_finish=NULL,
remarks=NULL
WHERE vehicle_id='$id'
");

echo "<script>

alert('Maintenance completed.');

window.location='index.php';

</script>";
?>
