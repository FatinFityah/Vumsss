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

$user_id    = intval($_POST['user_id']);
$full_name  = mysqli_real_escape_string($conn, trim($_POST['full_name']));
$staff_id   = mysqli_real_escape_string($conn, trim($_POST['staff_id']));
$department = mysqli_real_escape_string($conn, trim($_POST['department']));
$role       = mysqli_real_escape_string($conn, trim($_POST['role']));
$status     = mysqli_real_escape_string($conn, trim($_POST['status']));
$password   = trim($_POST['password']);

/* ==========================================
   CHECK DUPLICATE STAFF ID
========================================== */

$check = mysqli_query($conn,"
SELECT *
FROM users
WHERE staff_id='$staff_id'
AND user_id != '$user_id'
");

if(mysqli_num_rows($check) > 0){

    echo "<script>
    alert('Staff ID already exists.');
    history.back();
    </script>";

    exit();

}

/* ==========================================
   UPDATE USER
========================================== */

if(!empty($password)){

    $password = md5($password);

    $sql = "
    UPDATE users SET
        full_name='$full_name',
        staff_id='$staff_id',
        department='$department',
        role='$role',
        status='$status',
        password='$password'
    WHERE user_id='$user_id'
    ";

}else{

    $sql = "
    UPDATE users SET
        full_name='$full_name',
        staff_id='$staff_id',
        department='$department',
        role='$role',
        status='$status'
    WHERE user_id='$user_id'
    ";

}

if(mysqli_query($conn,$sql)){

    echo "<script>
    alert('User updated successfully!');
    window.location='index.php';
    </script>";

}else{

    echo "<script>
    alert('Failed to update user.');
    history.back();
    </script>";

}
?>
