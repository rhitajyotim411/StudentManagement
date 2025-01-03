<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
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
        $post = $_SESSION['post'];
        unset($_SESSION['post']);

        $tbname = "stu_dtl";
        $class = $post["class"];
        $rollno = $post['rollno'];
        $name = $post['name'];
        $guardian = $post['guardian'];
        $dob = $post['dob'];
        $address = $post['address'];
        $phone = $post['phone'];
        $email = $post['email'];

        $stmt = $conn->query("SELECT UID from {$tbname} where class='{$class}' and rollno='{$rollno}'");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            echo "<h5>Student with roll no. {$rollno} already registered in class {$class}</h5>";
        } else {
            try {
                // student registration
                $sql = "INSERT INTO {$tbname} (class, rollno, name, guardian, dob, address, phone, email)
        VALUES (:class, :rollno, :name, :guardian, :dob, :address, :phone, :email)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':class' => $class,
                    ':rollno' => $rollno,
                    ':name' => $name,
                    ':guardian' => $guardian,
                    ':dob' => $dob,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':email' => $email,
                ]);

            } catch (PDOException $e) {
                echo "Insertion failed: " . $e->getMessage();
                die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
            }

            echo "<h5>Registered Successfully</h5>";
        }
        ?>

        <div class="d-flex justify-content-center gap-2 m-3 flex-wrap">
            <form action="stu_reg.php" method="post">
                <input type="hidden" name="class" value="<?php echo $class; ?>">
                <input type="submit" name="submit" class="btn btn-primary" value="Register Another">
            </form>

            <form action="students_db.php" method="POST">
                <input type="hidden" name="class" value="<?php echo $class; ?>">
                <button type="submit" class="btn btn-primary">Student List</button>
            </form>
        </div>
    </div>
</body>

</html>