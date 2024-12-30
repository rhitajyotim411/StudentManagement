<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher details</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center mt-4">
        <?php
        if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        require_once '../inc/connect.php';

        $tbname = "tch_dtl";
        $uid = $_POST["tch_id"];
        $status = "";

        $stmt = $conn->query("SELECT * FROM $tbname WHERE uid='$uid'");
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
        $status = $teacher['Status'];
        ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Teacher Details</h4>
                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item"><strong>Name:</strong>
                                <?php echo htmlspecialchars($teacher['Name']); ?></li>
                            <li class="list-group-item"><strong>Date of Birth:</strong>
                                <?php echo htmlspecialchars($teacher['DOB']); ?></li>
                            <li class="list-group-item"><strong>Address:</strong>
                                <?php echo htmlspecialchars($teacher['Address']); ?></li>
                            <li class="list-group-item"><strong>Phone No.:</strong>
                                <?php echo htmlspecialchars($teacher['Phone']); ?></li>
                            <li class="list-group-item"><strong>Email:</strong>
                                <?php echo htmlspecialchars($teacher['Email']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <?php
                if ($status === 'active') {
                    ?>
                    <form action="tch_mng.php" method="POST" onsubmit="return confirmDelete();">
                        <input type="hidden" name="uid" value="<?php echo $teacher['UID']; ?>">
                        <input type="hidden" name="action" value="terminate">
                        <button type="submit" class="btn btn-danger">Terminate</button>
                    </form>

                    <form action="tch_updt.php" method="post">
                        <input type="hidden" name="uid" value="<?php echo htmlspecialchars($teacher['UID']); ?>">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($teacher['Name']); ?>">
                        <input type="hidden" name="dob" value="<?php echo htmlspecialchars($teacher['DOB']); ?>">
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($teacher['Address']); ?>">
                        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($teacher['Phone']); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($teacher['Email']); ?>">
                        <button type="submit" class="btn btn-warning">Edit details</button>
                    </form>

                    <form action="teachers_db.php" method="POST">
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="btn btn-primary">Active Teachers</button>
                    </form>
                    <?php
                } elseif ($status === 'former') {
                    ?>
                    <form action="tch_mng.php" method="POST" onsubmit="return confirmClear();">
                        <input type="hidden" name="uid" value="<?php echo $teacher['UID']; ?>">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="btn btn-danger">Clear Data</button>
                    </form>

                    <form action="tch_mng.php" method="POST" onsubmit="return confirmReinstate();">
                        <input type="hidden" name="uid" value="<?php echo $teacher['UID']; ?>">
                        <input type="hidden" name="action" value="reinstate">
                        <button type="submit" class="btn btn-warning">Reinstate</button>
                    </form>

                    <form action="teachers_db.php" method="POST">
                        <input type="hidden" name="status" value="former">
                        <button type="submit" class="btn btn-primary">Former Teachers</button>
                    </form>
                    <?php
                }
                ?>
                <form action="tch_rec.php" method="POST">
                    <input type="hidden" name="uid" value="<?php echo $teacher['UID']; ?>">
                    <button type="submit" class="btn btn-secondary">Attendance</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to terminate this teacher?");
        }

        function confirmClear() {
            return confirm(
                "Are you sure you want to clear data of this teacher?\n\n" +
                "You'll lose the following data:\n" +
                "- Attendance record"
            );
        }

        function confirmReinstate() {
            return confirm("Are you sure you want to reinstate this teacher?");
        }
    </script>
</body>

</html>