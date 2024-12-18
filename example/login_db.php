<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
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

        $tbname = "staff_login";
        $uid = $post["uid"];
        $passwd = $post["passwd"];

        $stmt = $conn->query("SELECT name, passwd from {$tbname} where uid='{$uid}'");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() < 1) {
            echo "<h5>No such user present</h5>";
            echo "<a class=\"ref\" href='../user/register.php'>Register here</a> ";
            echo "or <a class=\"ref\" href='./login.php'>login again</a>";
        } else {
            if (password_verify($passwd, $data['passwd'])) {
                $_SESSION['UID'] = $uid;
                $_SESSION['name'] = $data['name'];
                $_SESSION['type'] = 'staff';
                header("Location: ./dashboard.php");
            } else {
                echo "<span style=\"color: #f44900\">Wrong password</span><br>";
                echo "Redirecting to login...";
                header("refresh:2; URL=./login.php");
            }
        }
        ?>
    </div>
</body>

</html>