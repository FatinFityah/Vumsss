<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"SELECT * FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<?php include("sidebar.php"); ?>

<div class="col-lg-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold">

<i class="fa-solid fa-user"></i>

My Profile

</h2>

<a href="dashboard.php"
class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow-sm border-0 rounded-4">

<div class="card-body">

<div class="row">

<div class="col-md-3 text-center">

<img src="../assets/images/user.png"

class="rounded-circle shadow"

width="180">

<h4 class="mt-3">

<?= $user['full_name']; ?>

</h4>

<p class="text-muted">

<?= $user['role']; ?>

</p>

</div>

<div class="col-md-9">

<table class="table">

<tr>

<th width="220">

Full Name

</th>

<td>

<?= $user['full_name']; ?>

</td>

</tr>

<tr>

<th>

Staff ID

</th>

<td>

<?= $user['staff_id']; ?>

</td>

</tr>

<tr>

<th>

Department

</th>

<td>

<?= $user['department']; ?>

</td>

</tr>

<tr>

<th>

Role

</th>

<td>

<?= $user['role']; ?>

</td>

</tr>

<tr>

<th>

Status

</th>

<td>

<?php

if($user['status']=="Active"){

echo '<span class="badge bg-success">Active</span>';

}else{

echo '<span class="badge bg-danger">Inactive</span>';

}

?>

</td>

</tr>

<tr>

<th>

Created At

</th>

<td>

<?= date("d M Y h:i A",strtotime($user['created_at'])); ?>

</td>

</tr>
<tr>

<th>

Password

</th>

<td>

**************

</td>

</tr>

</table>

<div class="mt-4">

<a href="edit_profile.php"
class="btn btn-primary rounded-3">

<i class="fa-solid fa-user-pen"></i>

Edit Profile

</a>

<a href="change_password.php"
class="btn btn-warning rounded-3">

<i class="fa-solid fa-key"></i>

Change Password

</a>

<a href="dashboard.php"
class="btn btn-secondary rounded-3">

<i class="fa-solid fa-arrow-left"></i>

Back to Dashboard

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
