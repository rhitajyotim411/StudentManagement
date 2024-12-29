<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
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
            ?>

            <h2 class="mb-5">Teacher List</h2>

            <!-- Active -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Active Teacher</h5>
                        <form action="teachers_db.php" method="POST">
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Former -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Former Teacher</h5>
                        <form action="teachers_db.php" method="POST">
                            <input type="hidden" name="status" value="former">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>