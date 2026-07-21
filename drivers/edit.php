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

$driver_id = intval($_GET['id']);

$query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$driver_id'");

if (mysqli_num_rows($query) == 0) {
    echo "<script>
            alert('Driver not found.');
            window.location='index.php';
          </script>";
    exit();
}

$driver = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit Driver</title>

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

<i class="fa-solid fa-user-pen"></i>

Edit Driver

</h2>

<a href="index.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow">

<div class="card-body">

<form action="update.php" method="POST">

<input
type="hidden"
name="driver_id"
value="<?= $driver['driver_id']; ?>">

<div class="mb-3">

<label class="form-label">Driver Name</label>

<input
type="text"
name="driver_name"
class="form-control"
value="<?= htmlspecialchars($driver['driver_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Department</label>

<input
type="text"
name="department"
class="form-control"
value="<?= htmlspecialchars($driver['department']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone_number"
class="form-control"
value="<?= htmlspecialchars($driver['phone_number']); ?>">

</div>

<div class="mb-3">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option value="Available" <?= ($driver['status']=="Available") ? "selected" : ""; ?>>
Available
</option>

<option value="On Duty" <?= ($driver['status']=="On Duty") ? "selected" : ""; ?>>
On Duty
</option>

<option value="Unavailable" <?= ($driver['status']=="Unavailable") ? "selected" : ""; ?>>
Unavailable
</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">Remarks</label>

<textarea
name="remarks"
class="form-control"
rows="3"><?= htmlspecialchars($driver['remarks']); ?></textarea>

</div>

<button
type="submit"
class="btn btn-primary">

<i class="fa-solid fa-floppy-disk"></i>

Update Driver

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
