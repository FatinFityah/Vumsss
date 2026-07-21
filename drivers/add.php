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

<title>Add Driver</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<?php include("../sidebar.php"); ?>

<div class="col-lg-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold">

<i class="fa-solid fa-user-plus"></i>

Add New Driver

</h2>

<a href="index.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow">

<div class="card-body">

<form action="insert.php" method="POST">

<div class="mb-3">

<label class="form-label">Driver Name</label>

<input
type="text"
name="driver_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Department</label>

<input
type="text"
name="department"
class="form-control"
value="Administration & Human Resource"
required>

</div>

<div class="mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone_number"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option value="Available">Available</option>

<option value="On Duty">On Duty</option>

<option value="Unavailable">Unavailable</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">Remarks</label>

<textarea
name="remarks"
class="form-control"
rows="3"></textarea>

</div>

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save Driver

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
