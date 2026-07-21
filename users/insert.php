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

$full_name  = mysqli_real_escape_string($conn, trim($_POST['full_name']));
$staff_id   = mysqli_real_escape_string($conn, trim($_POST['staff_id']));
$department = mysqli_real_escape_string($conn, trim($_POST['department']));
$role       = mysqli_real_escape_string($conn, trim($_POST['role']));
$password   = md5(trim($_POST['password']));
$status     = mysqli_real_escape_string($conn, trim($_POST['status']));

/*
|--------------------------------------------------------------------------
| Set Approval Permission
|--------------------------------------------------------------------------
*/

if($role == "Super Admin"){

    $can_approve = "Yes";

}elseif($role == "Admin"){

    $can_approve = "Yes";

}else{

    $can_approve = "No";

}

/*
|--------------------------------------------------------------------------
| Prevent Duplicate Staff ID
|--------------------------------------------------------------------------
*/

$check = mysqli_query($conn,"
SELECT *
FROM users
WHERE staff_id='$staff_id'
");

if(mysqli_num_rows($check) > 0){

    echo "<script>

    alert('Staff ID already exists.');

    window.location='add.php';

    </script>";

    exit();

}

/*
|--------------------------------------------------------------------------
| Insert User
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO users
(
full_name,
department,
staff_id,
password,
role,
status,
can_approve
)

VALUES
(
'$full_name',
'$department',
'$staff_id',
'$password',
'$role',
'$status',
'$can_approve'
)";

if(mysqli_query($conn,$sql)){

    echo "<script>

    alert('User added successfully!');

    window.location='index.php';

    </script>";

}else{

    echo "<script>

    alert('Failed to add user.');

    history.back();

    </script>";

}
?>
