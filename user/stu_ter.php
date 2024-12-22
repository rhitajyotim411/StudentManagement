<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Termination</title>
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

        $tbname = "stu_dtl";
        $terTable = "stu_ter";
        $uid = $_POST['uid'];
        $class = $_POST['class'];
        $currentYear = date("Y"); // Get the current year

        try {
            // Start a transaction
            $conn->beginTransaction();

            // Fetch the student record
            $sqlFetch = "SELECT uid, class, rollno, name, guardian, dob, address, phone, email FROM {$tbname} WHERE uid = :uid";
            $stmtFetch = $conn->prepare($sqlFetch);
            $stmtFetch->execute([':uid' => $uid]);
            $studentData = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            if ($studentData) {
                // Insert the record into stu_ter
                $sqlInsert = "INSERT INTO {$terTable} (uid, year, class, rollno, name, guardian, dob, address, phone, email)
                              VALUES (:uid, :year, :class, :rollno, :name, :guardian, :dob, :address, :phone, :email)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->execute([
                    ':uid' => $studentData['uid'],
                    ':year' => $currentYear,
                    ':class' => $studentData['class'],
                    ':rollno' => $studentData['rollno'],
                    ':name' => $studentData['name'],
                    ':guardian' => $studentData['guardian'],
                    ':dob' => $studentData['dob'],
                    ':address' => $studentData['address'],
                    ':phone' => $studentData['phone'],
                    ':email' => $studentData['email']
                ]);

                // Delete the record from stu_dtl
                $sqlDelete = "DELETE FROM {$tbname} WHERE uid = :uid";
                $stmtDelete = $conn->prepare($sqlDelete);
                $stmtDelete->execute([':uid' => $uid]);

                // Commit the transaction
                $conn->commit();
                echo "<h5>Student record successfully terminated</h5>";
            } else {
                echo "<h5 style='color: red;'>No student record found for the given UID</h5>";
            }
        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $conn->rollBack();
            echo "Operation failed: " . $e->getMessage();
            die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
        }
        ?>

        <form class="mt-3" action="students_db.php" method="POST">
            <input type="hidden" name="class" value="<?php echo $class; ?>">
            <button type="submit" class="btn btn-primary">Student List</button>
        </form>
    </div>
</body>

</html>