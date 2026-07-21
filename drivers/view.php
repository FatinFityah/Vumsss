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

<title>Driver Details</title>

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

Driver Details

</h2>

<a href="index.php" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered">

<tr>
    <th width="30%">Driver Name</th>
    <td><?= htmlspecialchars($driver['driver_name']); ?></td>
</tr>

<tr>
    <th>Department</th>
    <td><?= htmlspecialchars($driver['department']); ?></td>
</tr>

<tr>
    <th>Phone Number</th>
    <td><?= htmlspecialchars($driver['phone_number']); ?></td>
</tr>

<tr>
    <th>Status</th>
    <td>
        <?php
        if($driver['status']=="Available"){
            echo "<span class='badge bg-success'>Available</span>";
        }elseif($driver['status']=="On Duty"){
            echo "<span class='badge bg-warning text-dark'>On Duty</span>";
        }else{
            echo "<span class='badge bg-danger'>Unavailable</span>";
        }
        ?>
    </td>
</tr>

<tr>
    <th>Remarks</th>
    <td><?= nl2br(htmlspecialchars($driver['remarks'])); ?></td>
</tr>

<tr>
    <th>Created At</th>
    <td><?= htmlspecialchars($driver['created_at']); ?></td>
</tr>

</table>

<a href="edit.php?id=<?= $driver['driver_id']; ?>" class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Edit

</a>

<a href="index.php" class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
