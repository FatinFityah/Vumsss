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

<title>Edit Profile</title>

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

<i class="fa-solid fa-user-pen"></i>

Edit Profile

</h2>

<a href="profile.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow-sm border-0 rounded-4">

<div class="card-body">

<form action="update_profile.php" method="POST">

<input type="hidden"
name="user_id"
value="<?= $user['user_id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
class="form-control"
name="full_name"
value="<?= htmlspecialchars($user['full_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Department

</label>

<input
type="text"
class="form-control"
name="department"
value="<?= htmlspecialchars($user['department']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Staff ID

</label>

<input
type="text"
class="form-control"
name="staff_id"
value="<?= htmlspecialchars($user['staff_id']); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Role

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($user['role']); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Status

</label>

<select
class="form-select"
name="status">

<option value="Active"
<?= $user['status']=="Active" ? "selected" : ""; ?>>
Active
</option>

<option value="Inactive"
<?= $user['status']=="Inactive" ? "selected" : ""; ?>>
Inactive
</option>

</select>

</div>
<div class="col-md-12 mt-4">

<hr>

<button
type="submit"
class="btn btn-primary rounded-3">

<i class="fa-solid fa-floppy-disk"></i>
Save Changes

</button>

<a
href="profile.php"
class="btn btn-secondary rounded-3">

<i class="fa-solid fa-arrow-left"></i>
Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
