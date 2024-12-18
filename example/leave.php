<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leave Application</title>
  <link rel="icon" type="image/x-icon" href="../favicon.ico">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- CSS -->
  <link href="../style/main.css" rel="stylesheet">
  <link href="../style/form.css" rel="stylesheet">
</head>

<body>
  <?php require '../inc/header.php' ?>
  <div class="container-fluid text-center mt-3">
    <?php
    if (!isset($_SESSION['UID'])) {
      echo "Please login to continue<br>";
      echo "Redirecting to login page...";
      die(header("refresh:2; URL=./login.php"));
    }
    if ($_SESSION['type'] != 'staff') {
      echo '<h2 style="color: red">Access Denied!!</h2>';
      echo 'Not a staff, Redirecting to dashboard...';
      die(header("refresh:2; URL=../admin/dashboard.php"));
    }
    ?>
    <div class="row justify-content-center mt-5">
      <div class="col-md-5 mt-3 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Apply for leave</h5>
            <p class="card-text">
            <form action="./leave_db.php" method="post">
              <div class="d-flex justify-content-center mt-3 mb-3">
                <div class="overflow-auto">
                  <table>
                    <!--Types of leave-->
                    <tr>
                      <td>
                        <label for="leave_type">Select type of leave:</label>
                      </td>
                      <td>
                        <select name="leave_type">
                          <option value="EL">Earned Leave (EL)</option>
                          <option value="CL">Casual Leave (CL)</option>
                          <option value="SL">Sick Leave (SL)</option>
                          <option value="OP">Outdoor duty (OP)</option>
                          <option value="LWP">Leave Without Pay (LWP)</option>
                        </select>
                      </td>
                    </tr>

                    <!--Duration-->
                    <tr>
                      <td><label for="from">From: </label></td>
                      <td><input type="date" name="from" /></td>
                    </tr>
                    <tr>
                      <td><label for="to">To: </label></td>
                      <td><input type="date" name="to" /></td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <input type="submit" class="btn btn-primary" />
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </form>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>