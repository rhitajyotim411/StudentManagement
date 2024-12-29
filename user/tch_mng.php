<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center mt-5">
        <?php
        if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        require_once '../inc/connect.php';

        $tbname = "tch_dtl";
        $uid = $_POST['uid'];
        $action = $_POST['action'];

        if ($action === 'terminate') {

            try {
                // teacher edit
                $sql = "UPDATE {$tbname}
                    SET status = :status
                    WHERE uid = :uid";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':status' => 'former',
                    ':uid' => $uid,
                ]);

            } catch (PDOException $e) {
                echo "Updation failed: " . $e->getMessage();
                die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
            }

            echo "<h5>Teacher record successfully terminated</h5>";

        } elseif ($action === 'reinstate') {

            try {
                // teacher edit
                $sql = "UPDATE {$tbname}
                    SET status = :status
                    WHERE uid = :uid";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':status' => 'active',
                    ':uid' => $uid,
                ]);

            } catch (PDOException $e) {
                echo "Updation failed: " . $e->getMessage();
                die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
            }

            echo "<h5>Teacher successfully reinstated</h5>";
        } elseif ($action === 'clear') {

            try {
                // Delete the student record
                $sql = "DELETE FROM {$tbname} WHERE uid = :uid";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':uid' => $uid]);

            } catch (PDOException $e) {
                echo "Deletion failed: " . $e->getMessage();
                die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
            }

            echo "<h5>Teacher record successfully cleared</h5>";
        }
        ?>

        <div class="d-flex justify-content-center gap-2 mt-3">
            <form action="teachers_db.php" method="POST">
                <input type="hidden" name="status" value="active">
                <button type="submit" class="btn btn-primary">Active Teachers</button>
            </form>

            <form action="teachers_db.php" method="POST">
                <input type="hidden" name="status" value="former">
                <button type="submit" class="btn btn-primary">Former Teachers</button>
            </form>
        </div>
    </div>
</body>

</html>