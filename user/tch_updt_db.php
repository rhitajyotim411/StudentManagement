<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Edit</title>
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

        $tbname = "tch_dtl";
        $uid = $post["uid"];
        $name = $post['name'];
        $dob = $post['dob'];
        $address = $post['address'];
        $phone = $post['phone'];
        $email = $post['email'];

        try {
            // teacher edit
            $sql = "UPDATE {$tbname}
            SET name = :name,
                dob = :dob,
                address = :address,
                phone = :phone,
                email = :email
            WHERE uid = :uid";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':dob' => $dob,
                ':address' => $address,
                ':phone' => $phone,
                ':email' => $email,
                ':uid' => $uid,
            ]);

        } catch (PDOException $e) {
            echo "Insertion failed: " . $e->getMessage();
            die("<br><a class=\"ref\" href='../index.php'>Homepage</a>");
        }

        echo "<h5>Details updated Successfully</h5>";
        ?>

        <div class="d-flex justify-content-center gap-2 mt-3">
            <form action="tch_updt.php" method="post">
                <input type="hidden" name="uid" value="<?php echo htmlspecialchars($uid); ?>">
                <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <input type="hidden" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <button type="submit" class="btn btn-primary">Try again</button>
            </form>

            <form action="teachers_db.php" method="POST">
                <input type="hidden" name="status" value="active">
                <button type="submit" class="btn btn-primary">Active Teachers</button>
            </form>
        </div>
    </div>
</body>

</html>