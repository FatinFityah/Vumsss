<?php

$today = mysqli_query($conn,"
SELECT
bookings.staff_name,
vehicles.vehicle_name,
vehicles.plate_number,
bookings.borrow_date,
bookings.expected_return,
bookings.status
FROM bookings
JOIN vehicles
ON bookings.vehicle_id = vehicles.vehicle_id
ORDER BY bookings.borrow_date ASC
LIMIT 10
");

?>

<div class="mt-5">

    <div class="card-box">

        <h3 class="page-title">

            📅 Recent Reservations

        </h3>

        <hr>

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Staff</th>

                    <th>Vehicle</th>

                    <th>Borrow Date</th>

                    <th>Return Date</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if(mysqli_num_rows($today)>0){

                while($row=mysqli_fetch_assoc($today)){

            ?>

                <tr>

                    <td>

                        <?= $row['staff_name']; ?>

                    </td>

                    <td>

                        <strong><?= $row['vehicle_name']; ?></strong><br>

                        <small><?= $row['plate_number']; ?></small>

                    </td>

                    <td>

                        <?= $row['borrow_date']; ?>

                    </td>

                    <td>

                        <?= $row['expected_return']; ?>

                    </td>

                    <td>

                        <?php

                        if($row['status']=="Reserved"){

                            echo '<span class="badge bg-warning text-dark">Reserved</span>';

                        }

                        elseif($row['status']=="In Use"){

                            echo '<span class="badge bg-primary">In Use</span>';

                        }

                        elseif($row['status']=="Returned"){

                            echo '<span class="badge bg-success">Returned</span>';

                        }

                        else{

                            echo '<span class="badge bg-secondary">'.$row['status'].'</span>';

                        }

                        ?>

                    </td>

                </tr>

            <?php

                }

            }else{

            ?>

                <tr>

                    <td colspan="5" class="text-center text-muted">

                        No reservation records found.

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>
