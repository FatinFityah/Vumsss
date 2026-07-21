<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Add User</title>

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

<i class="fa-solid fa-user-plus"></i>

Add New User

</h2>

<a href="index.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card-box">

<form action="insert.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="full_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Staff ID

</label>

<input
type="text"
name="staff_id"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Department

</label>

<input
type="text"
name="department"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Role

</label>

<select
name="role"
class="form-select"
required>

<option value="">-- Select Role --</option>

<option value="Super Admin">Super Admin</option>

<option value="Admin">Admin</option>

<option value="Staff">Staff</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select"
required>

<option value="Active">Active</option>

<option value="Inactive">Inactive</option>

</select>

</div>

</div>

<div class="mt-3">

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save User

</button>

<a
href="index.php"
class="btn btn-secondary">

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
