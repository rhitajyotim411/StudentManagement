<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List</title>
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
        <div class="row justify-content-center mt-3">
            <?php
            if (!isset($_SESSION['UID'])) {
                echo "Please login to continue<br>";
                echo "Redirecting to login page...";
                die(header("refresh:2; URL=./login.php"));
            }
            ?>

            <h2 class="mb-3">Class List</h2>

            <!-- Nursery -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Nursery</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="Nursery">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- KG1 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">KG1</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="KG1">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- KG2 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">KG2</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="KG2">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Class 1 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Class 1</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="Class 1">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Class 2 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Class 2</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="Class 2">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Class 3 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Class 3</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="Class 3">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Class 4 -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Class 4</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="Class 4">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>