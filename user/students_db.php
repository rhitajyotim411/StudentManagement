<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
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
    <div class="container-fluid text-center mt-3">
        <?php
        if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        require_once '../inc/connect.php';

        $tbname = "stu_dtl";
        $class = $_POST["class"];
        ?>

        <form class="mb-3" action="stu_reg.php" method="post">
            <input type="hidden" name="class" value="<?php echo $class ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Register student">
        </form>

        <?php
        $stmt = $conn->query("SELECT UID, RollNo, Name FROM $tbname where class='$class' ORDER BY RollNo");

        if ($stmt->rowCount() < 1) {
            die("<p>No students found<br></p>");
        }
        ?>

        <h2>Student List for <?php echo $class ?></h2>
        <div class="d-flex justify-content-center">
            <hr>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-3">
            <div class="overflow-auto">
                <table>
                    <tr>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th><!--filler--></th>
                    </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$row['RollNo']}</td>";
                        echo "<td>{$row['Name']}</td>";
                        echo "<td>{$class}</td>";
                        echo "<td>";
                        echo "<form action=\"./stu_dtl.php\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"stu_id\" value={$row['UID']}>";
                        echo "<input type=\"submit\" name=\"submit\" class=\"btn btn-primary\" value=\"View\">";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>