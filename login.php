<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TEGAS Smart Vehicle Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(
        135deg,
        #F8FFF9 0%,
        #EEF8F0 50%,
        #E7F4EC 100%
    );

    overflow:hidden;

}

/* Background */

.circle{

    position:absolute;
    border-radius:50%;
    z-index:0;
    opacity:.55;

}

.circle1{

    width:320px;
    height:320px;

    background:#DDF8E8;

    top:-90px;
    left:-90px;

}

.circle2{

    width:250px;
    height:250px;

    background:#DDEEFF;

    bottom:-70px;
    right:-70px;

}

.circle3{

    width:150px;
    height:150px;

    background:#FFF6D9;

    top:18%;
    right:8%;

}

/* Login Card */

.login-card{

    position:relative;
    z-index:10;

    width:430px;
    max-width:92%;

    background:#ffffff;

    border-radius:28px;

    padding:45px;

    box-shadow:0 18px 45px rgba(0,0,0,.08);

}

.logo{

    width:150px;

    display:block;

    margin:auto;

    margin-bottom:18px;

}

h2{

    text-align:center;

    color:#355070;

    font-size:32px;

    font-weight:700;

}

.subtitle{

    text-align:center;

    color:#7B8794;

    margin-bottom:30px;

}

.form-label{

    color:#355070;

    font-weight:500;

}

.input-group-text{

    background:#F8FBF8;

    border:1px solid #DDEFE2;

}

.form-control{

    height:52px;

    border-radius:0 14px 14px 0;

    border:1px solid #DDEFE2;

}

.form-control:focus{

    border-color:#8FD8B5;

    box-shadow:0 0 0 .2rem rgba(143,216,181,.25);

}

.input-group{

    margin-bottom:20px;

}

.btn-login{

    width:100%;

    height:54px;

    border:none;

    border-radius:14px;

    background:#8FD8B5;

    color:#355070;

    font-weight:600;

    font-size:16px;

    transition:.3s;

}

.btn-login:hover{

    background:#79C9A2;

    transform:translateY(-2px);

}

.footer{

    text-align:center;

    margin-top:22px;

    color:#8A8A8A;

    font-size:13px;

}

.version{

    text-align:center;

    color:#B0B0B0;

    margin-top:8px;

    font-size:11px;

}

</style>

</head>

<body>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>

<div class="login-card">

<img
src="assets/images/tegas-logo.png"
class="logo"
alt="TEGAS Logo">

<h2>Welcome Back</h2>

<p class="subtitle">

TEGAS Smart Vehicle Management System

</p>

<form action="login_process.php" method="POST">

<label class="form-label">

Staff ID

</label>

<div class="input-group">

<span class="input-group-text">

<i class="fa-solid fa-id-badge"></i>

</span>

<input
type="text"
name="staff_id"
class="form-control"
placeholder="Enter Staff ID"
required
autocomplete="username">

</div>

<label class="form-label">

Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="fa-solid fa-lock"></i>

</span>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter Password"
required
autocomplete="current-password">

<button
class="btn btn-light border"
type="button"
onclick="togglePassword()">

<i id="eyeIcon" class="fa-solid fa-eye"></i>

</button>

</div>

<button
type="submit"
class="btn-login">

<i class="fa-solid fa-right-to-bracket"></i>

&nbsp;

Login

</button>

</form>

<div class="footer">

Tabung Ekonomi Gagasan Anak Sarawak (TEGAS)

</div>

<div class="version">

Vehicle Management System • Version 1.0

</div>

</div>

<script>

function togglePassword(){

    const password=document.getElementById("password");

    const eye=document.getElementById("eyeIcon");

    if(password.type==="password"){

        password.type="text";

        eye.classList.remove("fa-eye");

        eye.classList.add("fa-eye-slash");

    }else{

        password.type="password";

        eye.classList.remove("fa-eye-slash");

        eye.classList.add("fa-eye");

    }

}

</script>

</body>

</html>
