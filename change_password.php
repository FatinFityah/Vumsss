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

<title>Change Password</title>

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

<i class="fa-solid fa-key"></i>

Change Password

</h2>

<a href="profile.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow-sm border-0 rounded-4">

<div class="card-body">

<form action="update_password.php" method="POST">

<input type="hidden"
name="user_id"
value="<?= $user['user_id']; ?>">

<div class="mb-3">

<label class="form-label">

Current Password

</label>

<input
type="password"
class="form-control"
name="current_password"
required>

</div>

<div class="mb-3">

<label class="form-label">

New Password

</label>

<input
type="password"
class="form-control"
name="new_password"
required>

</div>

<div class="mb-3">

<label class="form-label">

Confirm New Password

</label>

<input
type="password"
class="form-control"
name="confirm_password"
required>

</div>
<div class="mt-4">

<button
type="submit"
class="btn btn-primary rounded-3">

<i class="fa-solid fa-floppy-disk"></i>
Update Password

</button>

<a
href="profile.php"
class="btn btn-secondary rounded-3">

<i class="fa-solid fa-arrow-left"></i>
Cancel

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
