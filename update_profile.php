<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: profile.php");
    exit();
}

$user_id = intval($_POST['user_id']);

$full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
$department = mysqli_real_escape_string($conn, trim($_POST['department']));
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql = "UPDATE users SET
            full_name = '$full_name',
            department = '$department',
            status = '$status'
        WHERE user_id = '$user_id'";

if (mysqli_query($conn, $sql)) {

    echo "<script>
            alert('Profile updated successfully!');
            window.location='profile.php';
          </script>";

} else {

    echo "<script>
            alert('Failed to update profile!');
            history.back();
          </script>";

}
?>
