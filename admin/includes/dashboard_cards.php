<div class="row g-4">

    <!-- Available -->
    <div class="col-md-6 col-xl">
        <div class="stat-card bg-soft-green">

            <div class="dashboard-icon icon-green">
                <i class="fa-solid fa-car"></i>
            </div>

            <h6>Available Vehicles</h6>

            <h1><?= $available; ?></h1>

            <small class="text-muted">
                Ready for booking
            </small>

        </div>
    </div>

    <!-- Reserved -->
    <div class="col-md-6 col-xl">
        <div class="stat-card bg-soft-yellow">

            <div class="dashboard-icon icon-yellow">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <h6>Reserved</h6>

            <h1><?= $reserved; ?></h1>

            <small class="text-muted">
                Upcoming reservations
            </small>

        </div>
    </div>

    <!-- In Use -->
    <div class="col-md-6 col-xl">
        <div class="stat-card bg-soft-blue">

            <div class="dashboard-icon icon-blue">
                <i class="fa-solid fa-road"></i>
            </div>

            <h6>In Use</h6>

            <h1><?= $inUse; ?></h1>

            <small class="text-muted">
                Currently borrowed
            </small>

        </div>
    </div>

    <!-- Pending -->
    <div class="col-md-6 col-xl">
        <div class="stat-card bg-soft-purple">

            <div class="dashboard-icon icon-purple">
                <i class="fa-solid fa-clock"></i>
            </div>

            <h6>Pending Approval</h6>

            <h1><?= $pending; ?></h1>

            <small class="text-muted">
                Waiting for approval
            </small>

        </div>
    </div>

    <!-- Maintenance -->
    <div class="col-md-6 col-xl">
        <div class="stat-card bg-soft-pink">

            <div class="dashboard-icon icon-pink">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>

            <h6>Maintenance</h6>

            <h1><?= $maintenance; ?></h1>

            <small class="text-muted">
                Vehicles unavailable
            </small>

        </div>
    </div>

</div>
