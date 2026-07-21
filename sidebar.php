<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
.sidebar{
    min-height:100vh;
    background:#F8F9FF;
    border-right:1px solid #E5E7EB;
    padding-top:20px;
}

.sidebar .logo{
    text-align:center;
    margin-bottom:30px;
}

.sidebar .logo h4{
    color:#6C63FF;
    font-weight:700;
}

.sidebar .nav-link{
    display:block;
    color:#555;
    padding:12px 20px;
    margin:8px 12px;
    border-radius:15px;
    text-decoration:none;
    font-weight:500;
    transition:.25s;
}

.sidebar .nav-link:hover{
    background:#EEF2FF;
    color:#6C63FF;
}

.sidebar .nav-link.active{
    background:#6C63FF;
    color:#fff !important;
}

.sidebar .nav-link i{
    width:22px;
}

.logout-btn{
    margin:20px 12px;
}

.logout-btn .btn{
    border-radius:15px;
}
</style>

<div class="col-lg-2 sidebar">

    <div class="logo">
        <h4>
            <i class="fa-solid fa-shield-halved"></i><br>
            Super Admin
        </h4>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="/tegas-vms-v2/superadmin/dashboard.php"
               class="nav-link <?= ($currentPage=='dashboard.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="/tegas-vms-v2/superadmin/users/index.php"
               class="nav-link <?= (strpos($_SERVER['PHP_SELF'],'users')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-users"></i>
                Manage Users
            </a>
        </li>

        <li class="nav-item">
            <a href="/tegas-vms-v2/superadmin/vehicles/index.php"
               class="nav-link <?= (strpos($_SERVER['PHP_SELF'],'vehicles')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-car"></i>
                Manage Vehicles
            </a>
        </li>

        

        <li class="nav-item">
            <a href="/tegas-vms-v2/superadmin/reports/index.php"
               class="nav-link <?= (strpos($_SERVER['PHP_SELF'],'reports')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-column"></i>
                Reports
            </a>
        </li>

        <li class="nav-item">
            <a href="/tegas-vms-v2/superadmin/profile.php"
               class="nav-link <?= ($currentPage=='profile.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-user"></i>
                Profile
            </a>
        </li>

    </ul>

    <div class="logout-btn">
        <a href="/tegas-vms-v2/logout.php" class="btn btn-danger w-100">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</div>
