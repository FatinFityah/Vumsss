<?php

include("../../config/database.php");

$department_code = strtoupper(trim($_POST['department_code']));
$department_name = trim($_POST['department_name']);

echo "<h3>Connected Database: $database</h3>";

$sql = "INSERT INTO departments
(department_code, department_name)
VALUES
('$department_code','$department_name')";

echo "<pre>$sql</pre>";

$result = mysqli_query($conn, $sql);

if($result){
    echo "SUCCESS";
}else{
    die(mysqli_error($conn));
}
