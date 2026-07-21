<?php
include("../../config/auth.php");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Department</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4>Add Department</h4>

        </div>

        <div class="card-body">

            <form action="insert.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Department Code
                    </label>

                    <input
                        type="text"
                        name="department_code"
                        class="form-control"
                        placeholder="Example: DV"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Department Name
                    </label>

                    <input
                        type="text"
                        name="department_name"
                        class="form-control"
                        placeholder="Example: Digital Village"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    Save Department

                </button>

                <a href="index.php" class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>
