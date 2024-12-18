<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Homepage</title>
  <link rel="icon" type="image/x-icon" href="../favicon.ico">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- CSS -->
  <link href="../style/main.css" rel="stylesheet">
  <link href="../style/card.css" rel="stylesheet">
</head>

<body>
  <?php require '../inc/header.php' ?>
  <div class="container-fluid text-center">
    <div class="row justify-content-center mt-5">
      <?php
      if (isset($_SESSION['UID'])) {
        ?>
        <h5>
          <?php echo $_SESSION['UID'] ?> already logged in <br>
          Redirecting to dashboard...
        </h5>
        <?php
        die(header("refresh:2; URL=./dashboard.php"));
      }
      ?>
      <h1>Welcome</h1>
      <div class="col-sm-4 mt-5 mb-4">
        <div class="card">
          <div class="card-body user-card">
            <h5 class="card-title">Register</h5>
            <p class="card-text">Resgister as an user to use the portal</p>
            <a href="./register.php" class="btn btn-primary">Register</a>
          </div>
        </div>
      </div>
      <div class="col-sm-4 mt-5 mb-4">
        <div class="card">
          <div class="card-body user-card">
            <h5 class="card-title">Login</h5>
            <p class="card-text">Login as an user to use the portal</p>
            <a href="./login.php" class="btn btn-primary">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>