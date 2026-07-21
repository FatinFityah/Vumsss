<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$staff_name = $_SESSION['full_name'];
$department = $_SESSION['department'];

$vehicle_id = intval($_POST['vehicle_id']);
$purpose = trim($_POST['purpose']);
$destination = trim($_POST['destination']);
$borrow_date = date('Y-m-d');
$expected_return = $_POST['expected_return'];

/* Validate return date */

if($expected_return < $borrow_date){

    echo "
    <script>
        alert('Expected return date cannot be earlier than today.');
        window.history.back();
    </script>
    ";

    exit();
}

/* Check vehicle is still available */

$check = mysqli_query($conn, "
    SELECT vehicle_status
    FROM vehicles
    WHERE vehicle_id = '$vehicle_id'
    LIMIT 1
");

if(!$check || mysqli_num_rows($check) == 0){

    die("Vehicle not found.");

}

$vehicle = mysqli_fetch_assoc($check);

if($vehicle['vehicle_status'] != 'Available'){

    echo "
    <script>
        alert('Sorry, this vehicle is no longer available.');
        window.location='borrow_vehicle.php';
    </script>
    ";

    exit();
}

/* Check video upload */

if(
    !isset($_FILES['borrow_video']) ||
    $_FILES['borrow_video']['error'] != 0
){

    echo "
    <script>
        alert('Please upload the pre-borrow inspection video.');
        window.history.back();
    </script>
    ";

    exit();
}

/* Create upload folder if it does not exist */

$upload_folder = __DIR__ . "/uploads/";

if(!is_dir($upload_folder)){
    mkdir($upload_folder, 0777, true);
}

/* Create safe unique filename */

$original_name = basename($_FILES['borrow_video']['name']);

$extension = strtolower(
    pathinfo($original_name, PATHINFO_EXTENSION)
);

$allowed_extensions = [
    'mp4',
    'mov',
    'avi',
    'mkv',
    'webm'
];

if(!in_array($extension, $allowed_extensions)){

    echo "
    <script>
        alert('Invalid video format. Please upload a valid video file.');
        window.history.back();
    </script>
    ";

    exit();
}

$video_name =
    time()
    . "_"
    . uniqid()
    . "."
    . $extension;

$upload_path =
    $upload_folder
    . $video_name;

/* Move uploaded video */

if(!move_uploaded_file(
    $_FILES['borrow_video']['tmp_name'],
    $upload_path
)){

    die("Failed to upload inspection video.");

}

/* Save borrow request */

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
    borrow_video,
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
    '$video_name',
    'Pending Approval',
    'Pending Approval'
)
";

if(mysqli_query($conn, $sql)){

    echo "
    <script>
        alert('Borrow request submitted successfully. Please wait for Admin approval.');
        window.location='my_bookings.php';
    </script>
    ";

}else{

    /*
    Delete uploaded video if database insert fails.
    */

    if(file_exists($upload_path)){
        unlink($upload_path);
    }

    die(
        "Borrow Request Error: "
        . mysqli_error($conn)
    );

}
?>
