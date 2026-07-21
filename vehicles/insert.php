<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

include("../../config/database.php");

$result=mysqli_query($conn,"SELECT * FROM vehicles ORDER BY vehicle_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vehicle Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>
.vehicle-thumb{
width:75px;
height:55px;
object-fit:cover;
border-radius:10px;
}
</style>

</head>
<body>

<div class="container-fluid">
<div class="row">

<?php include("../includes/sidebar.php"); ?>

<div class="col-lg-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h2 class="page-title">🚗 Vehicle Management</h2>
<p class="subtitle">Manage company vehicles.</p>
</div>

<a href="add.php" class="btn btn-success">
<i class="fa-solid fa-plus"></i>
Add Vehicle
</a>

</div>

<div class="card-box mb-4">

<div class="row">

<div class="col-md-8 mb-2">
<input type="text" id="searchVehicle" class="form-control" placeholder="🔍 Search vehicle...">
</div>

<div class="col-md-4">
<select id="statusFilter" class="form-select">
<option value="">All Status</option>
<option>Available</option>
<option>Reserved</option>
<option>In Use</option>
<option>Maintenance</option>
</select>
</div>

</div>

</div>

<div class="card-box">

<div class="table-responsive">

<table class="table table-hover align-middle" id="vehicleTable">

<thead>

<tr>
<th>Photo</th>
<th>Vehicle</th>
<th>Plate Number</th>
<th>Status</th>
<th>Road Tax</th>
<th>Insurance</th>
<th width="180">Action</th>
</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

<?php if(!empty($row['vehicle_photo'])){ ?>

<img src="../../uploads/<?php echo $row['vehicle_photo']; ?>" class="vehicle-thumb">

<?php }else{ ?>

<i class="fa-solid fa-car-side fa-2x text-secondary"></i>

<?php } ?>

</td>

<td>

<strong><?php echo htmlspecialchars($row['vehicle_name']); ?></strong><br>

<small>

<?php
echo htmlspecialchars(($row['brand'] ?? '').' '.($row['model'] ?? ''));
?>

</small>

</td>

<td><?php echo htmlspecialchars($row['plate_number']); ?></td>

<td>

<?php
$status=$row['vehicle_status'];

if($status=="Available"){
echo '<span class="badge bg-success">Available</span>';
}elseif($status=="Reserved"){
echo '<span class="badge bg-warning text-dark">Reserved</span>';
}elseif($status=="In Use"){
echo '<span class="badge bg-primary">In Use</span>';
}else{
echo '<span class="badge bg-danger">Maintenance</span>';
}
?>

</td>

<td><?php echo $row['roadtax_expiry']; ?></td>

<td><?php echo $row['insurance_expiry']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['vehicle_id']; ?>" class="btn btn-primary btn-sm">
<i class="fa-solid fa-pen"></i>
</a>

<?php if($status=="Maintenance"){ ?>

<a href="finish_maintenance.php?id=<?php echo $row['vehicle_id']; ?>" class="btn btn-success btn-sm">
<i class="fa-solid fa-check"></i>
</a>

<?php }else{ ?>

<a href="maintenance.php?id=<?php echo $row['vehicle_id']; ?>" class="btn btn-warning btn-sm">
<i class="fa-solid fa-screwdriver-wrench"></i>
</a>

<?php } ?>

<a href="delete.php?id=<?php echo $row['vehicle_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this vehicle?')">
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

<script>
const search=document.getElementById("searchVehicle");
const filter=document.getElementById("statusFilter");

function filterTable(){

const term=search.value.toLowerCase();

const status=filter.value.toLowerCase();

document.querySelectorAll("#vehicleTable tbody tr").forEach(row=>{

const text=row.innerText.toLowerCase();

const vehicleStatus=row.cells[3].innerText.toLowerCase();

const show=text.includes(term)&&
(status==""||vehicleStatus.includes(status));

row.style.display=show?"":"none";

});

}

search.addEventListener("keyup",filterTable);
filter.addEventListener("change",filterTable);

</script>

</body>
</html>
