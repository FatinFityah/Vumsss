<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role']!="Admin"){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

function total($conn,$sql){
    $q = mysqli_query($conn,$sql);
    if(!$q){
        return 0;
    }

    $r = mysqli_fetch_assoc($q);

    return $r['total'] ?? 0;
}

$available   = total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='Available'");
$reserved    = total($conn,"SELECT COUNT(*) total FROM bookings WHERE status='Reserved'");
$inUse       = total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='In Use'");
$pending     = total($conn,"SELECT COUNT(*) total FROM bookings WHERE approval_status='Pending Approval'");
$maintenance = total($conn,"SELECT COUNT(*) total FROM vehicles WHERE vehicle_status='Maintenance'");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- Sidebar -->
        <?php include __DIR__ . "/includes/sidebar.php"; ?>

        <!-- Main Content -->
        <div class="col-lg-10 p-4">

            <h2 class="page-title">
                Good Morning,
                <?= htmlspecialchars($_SESSION['full_name']); ?> 👋
            </h2>

            <p class="subtitle">
                Fleet Management Control Centre
            </p>

            <hr>

            <!-- Dashboard Cards -->
            <?php include __DIR__ . "/includes/dashboard_cards.php"; ?>

            <!-- Quick Actions -->
            <?php include __DIR__ . "/includes/quick_actions.php"; ?>

            <!-- Notifications -->
            <?php include __DIR__ . "/includes/notifications.php"; ?>

            <!-- Vehicle Status -->
            <?php include __DIR__ . "/includes/vehicle_status.php"; ?>

            <!-- Recent Reservations -->
            <?php include __DIR__ . "/includes/today_reservations.php"; ?>

        </div>

    </div>

</div>

</body>

</html>
