<?php
include("config/database.php");

// Check if Super Admin already exists
$check = mysqli_query($conn, "SELECT * FROM users WHERE role='Super Admin'");

if (mysqli_num_rows($check) > 0) {
    die("✅ Super Admin already exists.");
}

// Create encrypted password
$password = password_hash("admin123", PASSWORD_DEFAULT);

// Insert Super Admin
$sql = "INSERT INTO users
(staff_id, full_name, email, phone, password, role, department_id)
VALUES
('SA001',
'Super Administrator',
'admin@tegas.com',
'0123456789',
'$password',
'Super Admin',
NULL)";

if(mysqli_query($conn, $sql)){
    echo "<h2>🎉 Super Admin created successfully!</h2>";
    echo "<p>Email: admin@tegas.com</p>";
    echo "<p>Password: admin123</p>";
    echo "<p><strong>Please delete setup.php after login is working.</strong></p>";
}else{
    echo mysqli_error($conn);
}
?>
