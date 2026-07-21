<?php

include("../../config/auth.php");
include("../../config/database.php");

$result = mysqli_query($conn,"SELECT * FROM departments ORDER BY department_name ASC");

?>

<!DOCTYPE html>

<html>

<head>

<title>Departments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>

Department Management

</h2>

<a href="add.php" class="btn btn-primary mb-3">

+ Add Department

</a>

<table class="table table-bordered">

<tr>

<th>No</th>

<th>Department Code</th>

<th>Department Name</th>

<th>Action</th>

</tr>

<?php

$no=1;

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['department_code']; ?></td>

<td><?= $row['department_name']; ?></td>

<td>

<a href="edit.php?id=<?= $row['department_id']; ?>" class="btn btn-warning btn-sm">

Edit

</a>

<a href="delete.php?id=<?= $row['department_id']; ?>" class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>
