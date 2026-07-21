<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: change_password.php");
    exit();
}

$user_id = intval($_POST['user_id']);

// Get form data
$current_password = trim($_POST['current_password']);
$new_password = trim($_POST['new_password']);
$confirm_password = trim($_POST['confirm_password']);

// Check if user exists
$query = mysqli_query($conn, "SELECT password FROM users WHERE user_id='$user_id'");

if (!$query || mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('User not found.');
            window.location='profile.php';
          </script>";
    exit();
}

$user = mysqli_fetch_assoc($query);

// Verify current password
if (md5($current_password) != $user['password']) {

    echo "<script>
            alert('Current password is incorrect.');
            history.back();
          </script>";
    exit();
}

// Check new password confirmation
if ($new_password != $confirm_password) {

    echo "<script>
            alert('New password and Confirm Password do not match.');
            history.back();
          </script>";
    exit();
}

// Optional: Prevent using the same password
if (md5($new_password) == $user['password']) {

    echo "<script>
            alert('New password cannot be the same as the current password.');
            history.back();
          </script>";
    exit();
}

// Update password (MD5 to match login_process.php)
$new_password_md5 = md5($new_password);

$update = mysqli_query($conn, "
    UPDATE users
    SET password='$new_password_md5'
    WHERE user_id='$user_id'
");

if ($update) {

    echo "<script>
            alert('Password changed successfully!');
            window.location='profile.php';
          </script>";

} else {

    echo "<script>
            alert('Failed to update password.');
            history.back();
          </script>";

}
?>
