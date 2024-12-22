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

            <!-- KG-I -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">KG-I</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="KG-I">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- KG-II -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">KG-II</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="KG-II">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- S-I -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">S-I</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="S-I">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- S-II -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">S-II</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="S-II">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- S-III -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">S-III</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="S-III">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- S-IV -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">S-IV</h5>
                        <form action="students_db.php" method="POST">
                            <input type="hidden" name="class" value="S-IV">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Alumni -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Alumni</h5>
                        <form action="#" method="POST">
                            <input type="hidden" name="class" value="Alumni">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Terminated -->
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body user-card d-flex flex-column align-items-center justify-content-center">
                        <h5 class="card-title">Terminated</h5>
                        <form action="terminate.php" method="POST">
                            <input type="hidden" name="class" value="Terminated">
                            <button type="submit" class="btn btn-primary">View</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>