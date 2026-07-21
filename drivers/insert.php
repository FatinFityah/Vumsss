<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: add.php");
    exit();
}

$driver_name = mysqli_real_escape_string($conn, trim($_POST['driver_name']));
$department = mysqli_real_escape_string($conn, trim($_POST['department']));
$phone_number = mysqli_real_escape_string($conn, trim($_POST['phone_number']));
$status = mysqli_real_escape_string($conn, $_POST['status']);
$remarks = mysqli_real_escape_string($conn, trim($_POST['remarks']));

$check = mysqli_query($conn,"
SELECT *
FROM drivers
WHERE driver_name='$driver_name'
");

if(mysqli_num_rows($check) > 0){

    echo "<script>
            alert('Driver already exists.');
            window.location='add.php';
          </script>";
    exit();
}

$sql = "INSERT INTO drivers
(
driver_name,
department,
phone_number,
status,
remarks
)
VALUES
(
'$driver_name',
'$department',
'$phone_number',
'$status',
'$remarks'
)";

if(mysqli_query($conn,$sql)){

    echo "<script>
            alert('Driver added successfully!');
            window.location='index.php';
          </script>";

}else{

    echo "<script>
            alert('Failed to add driver.');
            history.back();
          </script>";

}
?>
