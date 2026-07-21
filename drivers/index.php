<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM drivers
            WHERE driver_name LIKE '%$search%'
            OR department LIKE '%$search%'
            OR status LIKE '%$search%'
            ORDER BY driver_name ASC";
} else {

    $sql = "SELECT * FROM drivers
            ORDER BY driver_name ASC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Driver Management</title>

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

<i class="fa-solid fa-id-card"></i>

Driver Management

</h2>

<a href="add.php" class="btn btn-success">

<i class="fa-solid fa-plus"></i>

Add Driver

</a>

</div>

<form method="GET" class="mb-3">

<div class="input-group">

<input
type="text"
name="search"
class="form-control"
placeholder="Search driver..."
value="<?= htmlspecialchars($search); ?>">

<button class="btn btn-primary">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</div>

</form>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover align-middle">

<thead class="table-success">

<tr>

<th>No</th>

<th>Driver Name</th>

<th>Department</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= htmlspecialchars($row['driver_name']); ?></td>

<td><?= htmlspecialchars($row['department']); ?></td>

<td>

<?php

if($row['status']=="Available"){

    echo "<span class='badge bg-success'>Available</span>";

}elseif($row['status']=="On Duty"){

    echo "<span class='badge bg-warning text-dark'>On Duty</span>";

}else{

    echo "<span class='badge bg-danger'>Unavailable</span>";

}

?>

</td>

<td>

<a
href="view.php?id=<?= $row['driver_id']; ?>"
class="btn btn-info btn-sm">

<i class="fa-solid fa-eye"></i>

</a>

<a
href="edit.php?id=<?= $row['driver_id']; ?>"
class="btn btn-warning btn-sm">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="delete.php?id=<?= $row['driver_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this driver?')">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
