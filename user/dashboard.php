<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        <div class="row justify-content-center mt-4 mb-3">
            <?php
            if (!isset($_SESSION['UID'])) {
                echo "Please login to continue<br>";
                echo "Redirecting to login page...";
                die(header("refresh:2; URL=./login.php"));
            }
            ?>

            <div class="row row-cols-1 row-cols-md-3 g-3 justify-content-center ">
                <!-- Card 1 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Student Details</h5>
                            <p class="card-text">Fetch class-wise student details</p>
                            <a href="./students.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Teacher Details</h5>
                            <p class="card-text">Fetch teacher details</p>
                            <a href="./teachers.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Attendance</h5>
                            <p class="card-text">View student and teacher attendance</p>
                            <a href="./attendance.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Fees Collection</h5>
                            <p class="card-text">View monthly fees recorded</p>
                            <a href="./fees.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Class Routines</h5>
                            <p class="card-text">View class-wise student routine</p>
                            <a href="./routine.php" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>