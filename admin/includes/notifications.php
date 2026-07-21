<div class="row mt-5">

    <div class="col-lg-8">

        <div class="card-box">

            <h4>🔔 Notifications</h4>

            <hr>

            <?php if($pending > 0){ ?>

                <div class="alert alert-danger">

                    <strong><?= $pending; ?></strong> booking request(s) are waiting for approval.

                </div>

            <?php } ?>

            <?php if($maintenance > 0){ ?>

                <div class="alert alert-warning">

                    <strong><?= $maintenance; ?></strong> vehicle(s) are currently under maintenance.

                </div>

            <?php } ?>

            <?php if($pending == 0 && $maintenance == 0){ ?>

                <div class="alert alert-success">

                    🎉 Everything looks good today.

                </div>

            <?php } ?>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card-box">

            <h4>👤 Admin</h4>

            <hr>

            <h5><?= $_SESSION['full_name']; ?></h5>

            <p class="text-muted mb-1">
                <?= $_SESSION['department']; ?>
            </p>

            <p class="text-muted">
                Fleet Administrator
            </p>

            <a href="profile.php" class="btn btn-success w-100">

                Edit Profile

            </a>

        </div>

    </div>

</div>
