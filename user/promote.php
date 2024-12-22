<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student promotion</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php'; ?>
    <div class="container-fluid text-center mt-5">
        <?php
        if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        require_once '../inc/connect.php';

        $tbname = "stu_dtl";
        $tbalum = "alumni";
        $currentYear = date('Y');

        try {
            // Begin a transaction
            $conn->beginTransaction();

            // Move all S-IV students to alumni table
            $insertAlumniQuery = "INSERT INTO $tbalum (uid, year, rollno, name, guardian, dob, address, phone, email)
                                  SELECT uid, :year, rollno, name, guardian, dob, address, phone, email FROM $tbname WHERE class = 'S-IV';";
            $stmt = $conn->prepare($insertAlumniQuery);
            $stmt->execute(['year' => $currentYear]);

            // Delete all S-IV students from stu_dtl
            $deleteSIVQuery = "DELETE FROM $tbname WHERE class = 'S-IV';";
            $conn->exec($deleteSIVQuery);

            // Promote all students by one class
            $promotions = [
                'S-III' => 'S-IV',
                'S-II' => 'S-III',
                'S-I' => 'S-II',
                'KG-II' => 'S-I',
                'KG-I' => 'KG-II',
                'Nursery' => 'KG-I'
            ];

            foreach ($promotions as $oldClass => $newClass) {
                $updateClassQuery = "UPDATE $tbname SET class = :newClass WHERE class = :oldClass;";
                $stmt = $conn->prepare($updateClassQuery);
                $stmt->execute(['newClass' => $newClass, 'oldClass' => $oldClass]);
            }

            // Commit the transaction
            $conn->commit();

            echo "<h5>All students successfully promoted</h5>";
            echo "<h5>New alumni added</h5>";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            echo "<h5 style='color: red;'>An error occurred: " . htmlspecialchars($e->getMessage()) . "</h5>";
        }

        echo 'Redirecting to Class List...';
        header("refresh:5; URL=./students.php");
        ?>

    </div>
</body>

</html>