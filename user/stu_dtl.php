<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student details</title>
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

        $tbname = "stu_dtl";
        $uid = $_POST["stu_id"];

        $stmt = $conn->query("SELECT * FROM $tbname WHERE uid='$uid'");
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Student Details</h4>
                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item"><strong>Class:</strong>
                                <?php echo htmlspecialchars($student['Class']); ?></li>
                            <li class="list-group-item"><strong>Roll No.:</strong>
                                <?php echo htmlspecialchars($student['RollNo']); ?></li>
                            <li class="list-group-item"><strong>Name:</strong>
                                <?php echo htmlspecialchars($student['Name']); ?></li>
                            <li class="list-group-item"><strong>Guardian's Name:</strong>
                                <?php echo htmlspecialchars($student['Guardian']); ?></li>
                            <li class="list-group-item"><strong>Date of Birth:</strong>
                                <?php echo htmlspecialchars($student['DOB']); ?></li>
                            <li class="list-group-item"><strong>Address:</strong>
                                <?php echo htmlspecialchars($student['Address']); ?></li>
                            <li class="list-group-item"><strong>Phone No.:</strong>
                                <?php echo htmlspecialchars($student['Phone']); ?></li>
                            <li class="list-group-item"><strong>Email:</strong>
                                <?php echo htmlspecialchars($student['Email']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-3">
                <form action="stu_ter.php" method="POST" onsubmit="return confirmDelete();">
                    <input type="hidden" name="uid" value="<?php echo $student['UID']; ?>">
                    <input type="hidden" name="class" value="<?php echo $student['Class']; ?>">
                    <button type="submit" class="btn btn-danger">Terminate</button>
                </form>

                <form action="stu_updt.php" method="post">
                    <input type="hidden" name="uid" value="<?php echo htmlspecialchars($student['UID']); ?>">
                    <input type="hidden" name="class" value="<?php echo htmlspecialchars($student['Class']); ?>">
                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($student['RollNo']); ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($student['Name']); ?>">
                    <input type="hidden" name="guardian" value="<?php echo htmlspecialchars($student['Guardian']); ?>">
                    <input type="hidden" name="dob" value="<?php echo htmlspecialchars($student['DOB']); ?>">
                    <input type="hidden" name="address" value="<?php echo htmlspecialchars($student['Address']); ?>">
                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($student['Phone']); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($student['Email']); ?>">
                    <button type="submit" class="btn btn-warning">Edit details</button>
                </form>

                <form action="students_db.php" method="POST">
                    <input type="hidden" name="class" value="<?php echo $student['Class']; ?>">
                    <button type="submit" class="btn btn-primary">Student List</button>
                </form>

                <form action="stu_rec.php" method="POST">
                    <input type="hidden" name="uid" value="<?php echo $student['UID']; ?>">
                    <button type="submit" class="btn btn-secondary">View records</button>
                </form>

                <form action="ID_gen.php" method="post">
                    <input type="hidden" name="class" value="<?php echo htmlspecialchars($student['Class']); ?>">
                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($student['RollNo']); ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($student['Name']); ?>">
                    <input type="hidden" name="dob" value="<?php echo htmlspecialchars($student['DOB']); ?>">
                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($student['Phone']); ?>">
                    <button type="submit" class="btn btn-success">Generate ID</button>
                </form>

                <form action="Rprt_gen.php" method="post">
                    <input type="hidden" name="class" value="<?php echo htmlspecialchars($student['Class']); ?>">
                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($student['RollNo']); ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($student['Name']); ?>">
                    <input type="hidden" name="guardian" value="<?php echo htmlspecialchars($student['Guardian']); ?>">
                    <input type="hidden" name="dob" value="<?php echo htmlspecialchars($student['DOB']); ?>">
                    <button type="submit" class="btn btn-info">Generate Report</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to terminate this student?");
        }
    </script>
</body>

</html>