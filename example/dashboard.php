<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
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
        <div class="row justify-content-center mt-5">
            <?php
            if (!isset($_SESSION['UID'])) {
                echo "Please login to continue<br>";
                echo "Redirecting to login page...";
                die(header("refresh:2; URL=./login.php"));
            }
            if ($_SESSION['type'] != 'staff') {
                echo '<h2 style="color: red">Access Denied!!</h2>';
                echo 'Not a staff, Redirecting to dashboard...';
                die(header("refresh:2; URL=../admin/dashboard.php"));
            }
            ?>

            <h2>Welcome,
                <?php echo $_SESSION['name'] ?>
            </h2>

            <div class="col-sm-4 mt-5 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Apply for leave</h5>
                        <p class="card-text">
                            Visit to apply for a leave
                        </p>
                        <a href="./leave.php" class="btn btn-primary">Apply</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 mt-5 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Leaves Record</h5>
                        <p class="card-text">
                            View all registered leave records
                        </p>
                        <a href="./record.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>