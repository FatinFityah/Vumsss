<?php

session_start();

include("../config/database.php");

$id=$_POST['booking_id'];

$video="";

if(isset($_FILES['video'])){

$video=time()."_".basename($_FILES['video']['name']);

move_uploaded_file(

$_FILES['video']['tmp_name'],

"../uploads/".$video

);

}

mysqli_query($conn,"
UPDATE bookings
SET
borrow_video='$video',
approval_status='Pending Approval'
WHERE booking_id='$id'
");

echo "<script>

alert('Inspection video uploaded successfully.');

window.location='my_bookings.php';

</script>";

?>
