<?php

$vehicles = mysqli_query($conn,"
SELECT
vehicle_name,
plate_number,
vehicle_status
FROM vehicles
ORDER BY vehicle_name ASC
");

?>

<div class="mt-5">

    <h3 class="page-title mb-4">

        🚗 Vehicle Status

    </h3>

    <div class="row g-4">

    <?php while($row=mysqli_fetch_assoc($vehicles)){ ?>

        <div class="col-md-6 col-xl-3">

            <div class="card-box">

                <h5>

                    <?= $row['vehicle_name']; ?>

                </h5>

                <p class="text-muted">

                    <?= $row['plate_number']; ?>

                </p>

                <?php

                if($row['vehicle_status']=="Available"){

                    echo '<span class="badge bg-success">🟢 Available</span>';

                }

                elseif($row['vehicle_status']=="Reserved"){

                    echo '<span class="badge bg-warning text-dark">🟡 Reserved</span>';

                }

                elseif($row['vehicle_status']=="In Use"){

                    echo '<span class="badge bg-primary">🔵 In Use</span>';

                }

                elseif($row['vehicle_status']=="Maintenance"){

                    echo '<span class="badge bg-danger">🔴 Maintenance</span>';

                }

                else{

                    echo '<span class="badge bg-secondary">'.$row['vehicle_status'].'</span>';

                }

                ?>

            </div>

        </div>

    <?php } ?>

    </div>

</div>
