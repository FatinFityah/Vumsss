
<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff = $_SESSION['full_name'];

/* =========================
   DASHBOARD COUNTS
========================= */

/* Total reservations / bookings */
$totalBookingQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE staff_name='$staff'
");

$totalBooking = mysqli_fetch_assoc($totalBookingQuery)['total'];


/* Currently using vehicle */
$currentQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE staff_name='$staff'
    AND status='In Use'
");

$current = mysqli_fetch_assoc($currentQuery)['total'];


/* Available vehicles */
$availableQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM vehicles
    WHERE vehicle_status='Available'
");

$available = mysqli_fetch_assoc($availableQuery)['total'];


/* Pending approval */
$pendingQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE staff_name='$staff'
    AND approval_status='Pending Approval'
");

$pendingApproval = mysqli_fetch_assoc($pendingQuery)['total'];


/* Latest notifications / reminders */
$upcoming = mysqli_query($conn, "
    SELECT
        bookings.*,
        vehicles.vehicle_name,
        vehicles.plate_number
    FROM bookings
    JOIN vehicles
        ON bookings.vehicle_id = vehicles.vehicle_id
    WHERE bookings.staff_name='$staff'
    AND bookings.status='Reserved'
    AND bookings.borrow_date >= CURDATE()
    ORDER BY bookings.borrow_date ASC
    LIMIT 3
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title>Staff Dashboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link
rel="stylesheet"
href="../assets/css/style.css">

<style>

/* =========================
   MOBILE SIDEBAR
========================= */

@media(max-width: 991px){

    .sidebar{
        min-height:auto !important;
        padding-bottom:15px;
    }

    .sidebar .logo{
        padding-top:15px;
    }

}

/* Quick Action Cards */

.action-card{

    display:block;

    text-decoration:none;

    background:#ffffff;

    border-radius:20px;

    padding:25px;

    height:100%;

    box-shadow:0 8px 20px rgba(0,0,0,.07);

    transition:.3s;

    color:#355070;

}

.action-card:hover{

    transform:translateY(-5px);

    box-shadow:0 12px 25px rgba(0,0,0,.12);

    color:#355070;

}

.action-icon{

    width:55px;

    height:55px;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

    margin-bottom:15px;

}

.reserve-icon{

    background:#FFF1B8;

}

.borrow-icon{

    background:#D9EEFF;

}

.booking-icon{

    background:#DDF4EA;

}

.return-icon{

    background:#FFE0E0;

}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- =========================
     SIDEBAR
========================= -->

<div class="col-lg-2 sidebar">

<div class="logo text-center mt-4">

<i class="fa-solid fa-car-side fa-3x"></i>

<h3 class="mt-3">

TEGAS Fleet

</h3>

<p>

Smart Fleet Management

</p>

</div>

<hr>

<a href="dashboard.php">

<i class="fa-solid fa-house"></i>

Dashboard

</a>

<a href="calendar.php">

<i class="fa-solid fa-calendar-days"></i>

Calendar

</a>

<a href="book_vehicle.php">

<i class="fa-solid fa-calendar-check"></i>

Reserve Vehicle

</a>

<a href="borrow_vehicle.php">

<i class="fa-solid fa-car-side"></i>

Borrow Vehicle Today

</a>

<a href="my_bookings.php">

<i class="fa-solid fa-list-check"></i>

My Bookings

</a>

<a href="return_vehicle.php">

<i class="fa-solid fa-arrow-rotate-left"></i>

Return Vehicle

</a>

<a href="../logout.php">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>

</div>


<!-- =========================
     MAIN CONTENT
========================= -->

<div class="col-lg-10 p-4">

<h2 class="page-title">

Welcome,

<?= htmlspecialchars($_SESSION['full_name']); ?> 👋

</h2>

<p class="subtitle">

Welcome to TEGAS Smart Fleet Management System

</p>

<hr>


<!-- =========================
     DASHBOARD CARDS
========================= -->

<div class="row g-4">

<div class="col-md-6 col-xl-3">

<div class="dashboard-card">

<h6>

<i class="fa-solid fa-car"></i>

Available Vehicles

</h6>

<h1>

<?= $available; ?>

</h1>

<p class="text-muted mb-0">

Available for current use

</p>

</div>

</div>


<div class="col-md-6 col-xl-3">

<div class="dashboard-card">

<h6>

<i class="fa-solid fa-calendar-check"></i>

My Bookings

</h6>

<h1>

<?= $totalBooking; ?>

</h1>

<p class="text-muted mb-0">

Total booking records

</p>

</div>

</div>


<div class="col-md-6 col-xl-3">

<div class="dashboard-card">

<h6>

<i class="fa-solid fa-clock"></i>

Pending Approval

</h6>

<h1>

<?= $pendingApproval; ?>

</h1>

<p class="text-muted mb-0">

Waiting for Admin review

</p>

</div>

</div>


<div class="col-md-6 col-xl-3">

<div class="dashboard-card">

<h6>

<i class="fa-solid fa-road"></i>

Currently Using

</h6>

<h1>

<?= $current; ?>

</h1>

<p class="text-muted mb-0">

Vehicles currently borrowed

</p>

</div>

</div>

</div>


<!-- =========================
     QUICK ACTIONS
========================= -->

<div class="mt-5">

<h3 class="page-title">

Quick Actions

</h3>

<p class="subtitle">

Choose what you would like to do.

</p>

<div class="row g-4">


<!-- Reserve Vehicle -->

<div class="col-md-6 col-xl-3">

<a
href="book_vehicle.php"
class="action-card">

<div class="action-icon reserve-icon">

<i class="fa-solid fa-calendar-plus"></i>

</div>

<h5>

Reserve Vehicle

</h5>

<p class="text-muted mb-0">

Reserve a vehicle for a future date.

</p>

</a>

</div>


<!-- Borrow Vehicle Today -->

<div class="col-md-6 col-xl-3">

<a
href="borrow_vehicle.php"
class="action-card">

<div class="action-icon borrow-icon">

<i class="fa-solid fa-car-side"></i>

</div>

<h5>

Borrow Vehicle Today

</h5>

<p class="text-muted mb-0">

Borrow an available vehicle for immediate use.

</p>

</a>

</div>


<!-- My Bookings -->

<div class="col-md-6 col-xl-3">

<a
href="my_bookings.php"
class="action-card">

<div class="action-icon booking-icon">

<i class="fa-solid fa-list-check"></i>

</div>

<h5>

My Bookings

</h5>

<p class="text-muted mb-0">

View reservations and borrow requests.

</p>

</a>

</div>


<!-- Return Vehicle -->

<div class="col-md-6 col-xl-3">

<a
href="return_vehicle.php"
class="action-card">

<div class="action-icon return-icon">

<i class="fa-solid fa-arrow-rotate-left"></i>

</div>

<h5>

Return Vehicle

</h5>

<p class="text-muted mb-0">

Return a vehicle currently in use.

</p>

</a>

</div>

</div>

</div>


<!-- =========================
     UPCOMING RESERVATIONS
========================= -->

<div class="card-box mt-5">

<h4>

<i class="fa-solid fa-calendar-days"></i>

Upcoming Reservations

</h4>

<hr>

<?php if(mysqli_num_rows($upcoming) > 0){ ?>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>Vehicle</th>

<th>Borrow Date</th>

<th>Return Date</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($upcoming)){ ?>

<tr>

<td>

<strong>

<?= htmlspecialchars($row['vehicle_name']); ?>

</strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['plate_number']); ?>

</small>

</td>

<td>

<?= htmlspecialchars($row['borrow_date']); ?>

</td>

<td>

<?= htmlspecialchars($row['expected_return']); ?>

</td>

<td>

<span class="badge bg-warning text-dark">

Reserved

</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php }else{ ?>

<div class="text-center py-4">

<i
class="fa-solid fa-calendar-xmark fa-3x text-muted">
</i>

<p class="text-muted mt-3 mb-0">

No upcoming reservations.

</p>

</div>

<?php } ?>

</div>


<!-- =========================
     IMPORTANT INFORMATION
========================= -->

<div class="card-box mt-4 mb-5">

<h4>

<i class="fa-solid fa-circle-info"></i>

How It Works

</h4>

<hr>

<div class="row">

<div class="col-md-6 mb-3">

<div class="alert alert-warning h-100">

<strong>

<i class="fa-solid fa-calendar-check"></i>

Reserve Vehicle

</strong>

<br><br>

Use this option when you need a vehicle for a
<strong>future date</strong>.

No inspection video is required during reservation.

</div>

</div>

<div class="col-md-6 mb-3">

<div class="alert alert-info h-100">

<strong>

<i class="fa-solid fa-car-side"></i>

Borrow Vehicle Today

</strong>

<br><br>

Use this option when you need an available vehicle
<strong>today</strong>.

A pre-borrow inspection video is required before Admin approval.

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
