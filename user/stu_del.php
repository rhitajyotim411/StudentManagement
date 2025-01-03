<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Deletion</title>
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

        $tbname = $_POST['tbname'];
        $tbfees = "fees";
        $tbatt = "stu_att";
        $uid = $_POST['uid'];

        try {
            // Delete the student record
            $sql = "DELETE FROM {$tbname} WHERE uid = :uid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':uid' => $uid]);

            // Delete the fees record
            $sql = "DELETE FROM {$tbfees} WHERE uid = :uid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':uid' => $uid]);

            // Delete the attendance record
            $sql = "DELETE FROM {$tbatt} WHERE uid = :uid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':uid' => $uid]);

        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
            die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
        }

        echo "<h5>Student record successfully cleared</h5>";

        if ($tbname === 'stu_ter') {
            ?>

            <form class="mt-3" action="terminate.php" method="POST">
                <button type="submit" class="btn btn-primary">Terminated Students</button>
            </form>
            <?php
        } elseif ($tbname === 'alumni') {
            ?>
            <form class="mt-3" action="alumni.php" method="POST">
                <button type="submit" class="btn btn-primary">Alumni List</button>
            </form>
            <?php
        }
        ?>

    </div>
</body>

</html>