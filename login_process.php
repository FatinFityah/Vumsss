<?php
session_start();
include("config/database.php");

$staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);
$password = md5($_POST['password']);

$sql = "SELECT * FROM users
        WHERE staff_id='$staff_id'
        AND password='$password'
        AND status='Active'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){

    $user = mysqli_fetch_assoc($result);

    // Store user information in session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['staff_id'] = $user['staff_id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['department'] = $user['department'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['status'] = $user['status'];

    // Redirect based on role
    if($user['role'] == "Super Admin"){

        header("Location: superadmin/dashboard.php");

    }elseif($user['role'] == "Admin"){

        header("Location: admin/dashboard.php");

    }elseif($user['role'] == "Staff"){

        header("Location: staff/dashboard.php");

    }else{

        echo "<script>
        alert('Invalid user role!');
        window.location='login.php';
        </script>";

    }

    exit();

}else{

    echo "<script>
    alert('Invalid Staff ID or Password!');
    window.location='login.php';
    </script>";

}
?>
