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

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
");

if(mysqli_num_rows($query)==0){

    echo "<script>
    alert('User not found.');
    window.location='index.php';
    </script>";

    exit();

}

$user=mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>User Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<?php include("../sidebar.php"); ?>

<div class="col-lg-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="page-title">

<i class="fa-solid fa-user"></i>

User Details

</h2>

<a href="index.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card-box">

<table class="table table-bordered">

<tr>

<th width="30%">Full Name</th>

<td><?= htmlspecialchars($user['full_name']); ?></td>

</tr>

<tr>

<th>Staff ID</th>

<td><?= htmlspecialchars($user['staff_id']); ?></td>

</tr>

<tr>

<th>Department</th>

<td><?= htmlspecialchars($user['department']); ?></td>

</tr>

<tr>

<th>Role</th>

<td>

<?php

if($user['role']=="Super Admin"){

echo "<span class='badge bg-danger'>👑 Super Admin</span>";

}elseif($user['role']=="Admin"){

echo "<span class='badge bg-primary'>🛡 Admin</span>";

}else{

echo "<span class='badge bg-secondary'>👤 Staff</span>";

}

?>

</td>

</tr>

<tr>

<th>Status</th>

<td>

<?php

if($user['status']=="Active"){

echo "<span class='badge bg-success'>Active</span>";

}else{

echo "<span class='badge bg-danger'>Inactive</span>";

}

?>

</td>

</tr>

<tr>

<th>Created At</th>

<td><?= htmlspecialchars($user['created_at']); ?></td>

</tr>

</table>

<div class="mt-3">

<a
href="edit.php?id=<?= $user['user_id']; ?>"
class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Edit User

</a>

<a
href="index.php"
class="btn btn-secondary">

Back

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
