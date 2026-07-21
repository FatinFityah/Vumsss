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

$query = mysqli_query($conn,"SELECT * FROM users WHERE user_id='$user_id'");

if(mysqli_num_rows($query)==0){

    echo "<script>
    alert('User not found.');
    window.location='index.php';
    </script>";
    exit();

}

$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit User</title>

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
<i class="fa-solid fa-user-pen"></i>
Edit User
</h2>

<a href="index.php" class="btn btn-secondary">
<i class="fa-solid fa-arrow-left"></i>
Back
</a>

</div>

<div class="card-box">

<form action="update.php" method="POST">

<input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Full Name</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?= htmlspecialchars($user['full_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Staff ID</label>

<input
type="text"
name="staff_id"
class="form-control"
value="<?= htmlspecialchars($user['staff_id']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Department</label>

<input
type="text"
name="department"
class="form-control"
value="<?= htmlspecialchars($user['department']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Role</label>

<select
name="role"
class="form-select"
required>

<option value="Super Admin" <?= ($user['role']=="Super Admin")?"selected":""; ?>>Super Admin</option>

<option value="Admin" <?= ($user['role']=="Admin")?"selected":""; ?>>Admin</option>

<option value="Staff" <?= ($user['role']=="Staff")?"selected":""; ?>>Staff</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

New Password
<small class="text-muted">(Leave blank to keep current password)</small>

</label>

<input
type="password"
name="password"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select"
required>

<option value="Active" <?= ($user['status']=="Active")?"selected":""; ?>>Active</option>

<option value="Inactive" <?= ($user['status']=="Inactive")?"selected":""; ?>>Inactive</option>

</select>

</div>

</div>

<div class="mt-3">

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Update User

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

</body>

</html>
