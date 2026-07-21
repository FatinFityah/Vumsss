<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| Prevent deleting yourself
|--------------------------------------------------------------------------
*/

if($user_id == $_SESSION['user_id']){

    echo "<script>

    alert('You cannot delete your own account.');

    window.location='index.php';

    </script>";

    exit();

}

/*
|--------------------------------------------------------------------------
| Check user exists
|--------------------------------------------------------------------------
*/

$check = mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
");

if(mysqli_num_rows($check)==0){

    echo "<script>

    alert('User not found.');

    window.location='index.php';

    </script>";

    exit();

}

/*
|--------------------------------------------------------------------------
| Delete User
|--------------------------------------------------------------------------
*/

$sql = "
DELETE FROM users
WHERE user_id='$user_id'
";

if(mysqli_query($conn,$sql)){

    echo "<script>

    alert('User deleted successfully.');

    window.location='index.php';

    </script>";

}else{

    echo "<script>

    alert('Failed to delete user.');

    window.location='index.php';

    </script>";

}
?>
