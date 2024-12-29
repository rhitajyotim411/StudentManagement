<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attendacne</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/card.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center">
        <?php
        if (!isset($_SESSION['UID'])) {
            echo "Please login to continue<br>";
            echo "Redirecting to login page...";
            die(header("refresh:2; URL=./login.php"));
        }
        ?>
        <div class="row justify-content-center mt-3">
            <h1>Student Attendance</h1>
            <div class="col-sm-4 mt-3 mb-3">
                <div class="card">
                    <div class="card-body user-card">
                        <h5 class="card-title">Daily Attendance</h5>
                        <p class="card-text">Use to log today's attendance</p>
                        <a href="./daily_att.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-3 mb-3">
                <div class="card">
                    <div class="card-body user-card">
                        <h5 class="card-title">Monthly Summary</h5>
                        <p class="card-text">View monthly attendance summary</p>
                        <a href="./mon_att.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <h1>Teacher Attendance</h1>
            <div class="col-sm-4 mt-3 mb-3">
                <div class="card">
                    <div class="card-body user-card">
                        <h5 class="card-title">Daily Attendance</h5>
                        <p class="card-text">Use to log today's attendance</p>
                        <a href="./daily_att_tch.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>