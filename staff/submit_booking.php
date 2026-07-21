<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff_name = $_POST['staff_name'];
$department = $_POST['department'];
$vehicle_id = intval($_POST['vehicle_id']);
$purpose = $_POST['purpose'];
$destination = $_POST['destination'];
$borrow_date = $_POST['borrow_date'];
$expected_return = $_POST['expected_return'];

/* Validate Dates */

if($expected_return < $borrow_date){

    echo "
    <script>
        alert('Expected return date cannot be earlier than the borrow date.');
        window.history.back();
    </script>
    ";

    exit();
}

/* Save Reservation */

$sql = "
INSERT INTO bookings
(
    staff_name,
    department,
    vehicle_id,
    purpose,
    destination,
    borrow_date,
    expected_return,
    status,
    approval_status
)

VALUES
(
    '$staff_name',
    '$department',
    '$vehicle_id',
    '$purpose',
    '$destination',
    '$borrow_date',
    '$expected_return',
    'Reserved',
    'Pending Video'
)
";

if(mysqli_query($conn, $sql)){

    echo "
    <script>
        alert('Vehicle reservation submitted successfully!');
        window.location='my_bookings.php';
    </script>
    ";

}else{

    die(
        "Reservation Error: "
        . mysqli_error($conn)
    );

}
?>
