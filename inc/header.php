<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <!-- Left -->
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Home</a>
  </div>

  <?php
  if (isset($_SESSION['UID']) and basename($_SERVER['SCRIPT_NAME'], ".php") !== 'logout') {
    ?>
    <!-- Center -->
    <div class="container-fluid justify-content-center">
      <div class="d-flex flex-grow-1 justify-content-center">
        <ul class="navbar-nav">
          <!-- List -->
          <li class="nav-item">
            <a class="nav-link" href="./dashboard.php">Dashboard</a>
          </li>
          <?php
          // Check if on the student details or class list page
          $currentPage = basename($_SERVER['SCRIPT_NAME'], ".php");
          if (
            $currentPage === 'students_db'
            || $currentPage === 'stu_reg'
            || $currentPage === 'stu_dtl'
            || $currentPage === 'stu_updt'
            || $currentPage === 'alumni'
            || $currentPage === 'terminate'
          ) {
            ?>
            <li class="nav-item">
              <a class="nav-link" href="./students.php">Class List</a>
            </li>
          <?php } elseif (
            $currentPage === 'daily_att'
            || $currentPage === 'mon_att'
          ) {
            ?>
            <li class="nav-item">
              <a class="nav-link" href="./attendance.php">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./daily_att.php">Daily</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./mon_att.php">Montly</a>
            </li>
          <?php } elseif (
            $currentPage === 'teachers_db'
            || $currentPage === 'tch_reg'
            || $currentPage === 'tch_dtl'
            || $currentPage === 'tch_updt'
          ) {
            ?>
            <li class="nav-item">
              <a class="nav-link" href="./teachers.php">Teacher List</a>
            </li>
          <?php } elseif (
            $currentPage === 'daily_att_tch'
          ) {
            ?>
            <li class="nav-item">
              <a class="nav-link" href="./attendance.php">Attendance</a>
            </li>
          <?php }
          ?>
        </ul>
      </div>
    </div>

    <!-- Right -->
    <div class="container-fluid justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item dropstart">
          <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </button>
          <ul class="dropdown-menu">
            <li><span class="dropdown-item-text">
                <?php echo $_SESSION['UID'] ?>
              </span></li>
            <li><span class="dropdown-item-text">
                <?php echo $_SESSION['name'] ?>
              </span></li>
            <li>
              <a class="dropdown-item" style="color: #f44900" href="../user/logout.php">
                Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  <?php } ?>
</nav>