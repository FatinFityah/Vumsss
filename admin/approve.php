<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

/* Validate booking ID */

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){

    die("Invalid booking ID.");

}

$id = intval($_GET['id']);

$admin = $_SESSION['full_name'];

/*
Get the booking first.

We need the vehicle_id before updating
the vehicle status.
*/

$getBooking = mysqli_query($conn, "
    SELECT *
    FROM bookings
    WHERE booking_id = '$id'
    LIMIT 1
");

if(!$getBooking){

    die(
        "Booking Query Error: "
        . mysqli_error($conn)
    );

}

if(mysqli_num_rows($getBooking) == 0){

    die("Booking not found.");

}

$booking = mysqli_fetch_assoc($getBooking);

$vehicle_id = intval($booking['vehicle_id']);

/*
Security / workflow check:
Only Pending Approval requests can be approved.
*/

if($booking['approval_status'] != 'Pending Approval'){

    echo "
    <script>
        alert('This request is no longer pending approval.');
        window.location='approvals.php';
    </script>
    ";

    exit();

}

/*
Video is mandatory before approval.
*/

if(empty($booking['borrow_video'])){

    echo "
    <script>
        alert('Cannot approve this request because no inspection video was uploaded.');
        window.location='approvals.php';
    </script>
    ";

    exit();

}

/*
Check that the vehicle is still available.
*/

$vehicleCheck = mysqli_query($conn, "
    SELECT vehicle_status
    FROM vehicles
    WHERE vehicle_id = '$vehicle_id'
    LIMIT 1
");

if(!$vehicleCheck || mysqli_num_rows($vehicleCheck) == 0){

    die("Vehicle not found.");

}

$vehicle = mysqli_fetch_assoc($vehicleCheck);

if($vehicle['vehicle_status'] != 'Available'){

    echo "
    <script>
        alert('This vehicle is no longer available and the request cannot be approved.');
        window.location='approvals.php';
    </script>
    ";

    exit();

}

/*
Start database transaction.

Both updates must succeed:
1. Booking becomes In Use
2. Vehicle becomes In Use
*/

mysqli_begin_transaction($conn);

try{

    /*
    Update booking
    */

    $updateBooking = mysqli_query($conn, "
        UPDATE bookings
        SET
            status = 'In Use',
            approval_status = 'Approved',
            approval_by = '$admin',
            approval_date = NOW()
        WHERE booking_id = '$id'
    ");

    if(!$updateBooking){

        throw new Exception(
            "Booking Update Error: "
            . mysqli_error($conn)
        );

    }

    /*
    Update vehicle
    */

    $updateVehicle = mysqli_query($conn, "
        UPDATE vehicles
        SET vehicle_status = 'In Use'
        WHERE vehicle_id = '$vehicle_id'
    ");

    if(!$updateVehicle){

        throw new Exception(
            "Vehicle Update Error: "
            . mysqli_error($conn)
        );

    }

    /*
    Save both changes
    */

    mysqli_commit($conn);

    echo "
    <script>
        alert('Borrow request approved successfully. Vehicle is now In Use.');
        window.location='approvals.php';
    </script>
    ";

}catch(Exception $e){

    /*
    Undo all changes if anything fails.
    */

    mysqli_rollback($conn);

    die($e->getMessage());

}
?>
