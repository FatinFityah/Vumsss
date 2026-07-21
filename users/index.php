<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$search = "";

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $sql = "
    SELECT *
    FROM users
    WHERE
        full_name LIKE '%$search%'
        OR staff_id LIKE '%$search%'
        OR department LIKE '%$search%'
        OR role LIKE '%$search%'
    ORDER BY
        FIELD(role,'Super Admin','Admin','Staff'),
        full_name ASC
    ";

}else{

    $sql = "
    SELECT *
    FROM users
    ORDER BY
        FIELD(role,'Super Admin','Admin','Staff'),
        full_name ASC
    ";

}

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>User Management</title>

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

<div>

<h2 class="page-title">

<i class="fa-solid fa-users"></i>

User Management

</h2>

<p class="subtitle">

Manage Staff, Admin and Super Admin Accounts

</p>

</div>

<a href="add.php" class="btn btn-success">

<i class="fa-solid fa-user-plus"></i>

Add User

</a>

</div>

<div class="card-box">

<form method="GET" class="row g-3 mb-4">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by name, staff ID, department or role..."
value="<?= htmlspecialchars($search); ?>">

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</div>

</form>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No</th>

<th>Name</th>

<th>Staff ID</th>

<th>Department</th>

<th>Role</th>

<th>Status</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= $no++; ?></td>

<td>

<strong><?= htmlspecialchars($row['full_name']); ?></strong>

</td>

<td><?= htmlspecialchars($row['staff_id']); ?></td>

<td><?= htmlspecialchars($row['department']); ?></td>

<td>

<?php

if($row['role']=="Super Admin"){

    echo "<span class='badge bg-danger'>👑 Super Admin</span>";

}elseif($row['role']=="Admin"){

    echo "<span class='badge bg-primary'>🛡 Admin</span>";

}else{

    echo "<span class='badge bg-secondary'>👤 Staff</span>";

}

?>

</td>

<td>

<?php

if($row['status']=="Active"){

    echo "<span class='badge bg-success'>Active</span>";

}else{

    echo "<span class='badge bg-danger'>Inactive</span>";

}

?>

</td>

<td>

<a
href="view.php?id=<?= $row['user_id']; ?>"
class="btn btn-info btn-sm">

<i class="fa-solid fa-eye"></i>

</a>

<a
href="edit.php?id=<?= $row['user_id']; ?>"
class="btn btn-warning btn-sm">

<i class="fa-solid fa-pen"></i>

</a>

<?php if($row['user_id'] != $_SESSION['user_id']){ ?>

<a
href="delete.php?id=<?= $row['user_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this user?')">

<i class="fa-solid fa-trash"></i>

</a>

<?php } ?>

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
