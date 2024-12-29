<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Attendance</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/tick.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php'; ?>
    <div class="container-fluid text-center mt-3">
        <?php
        if (!isset($_SESSION['UID'])) {
            echo "Please login to continue<br>";
            echo "Redirecting to login page...";
            die(header("refresh:2; URL=./login.php"));
        }

        require_once '../inc/connect.php';

        $tbname = "tch_att";
        $current_date = date('Y-m-d');

        // Handle attendance toggle
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance_action'])) {
            try {
                if ($_POST['attendance_action'] === 'mark') {
                    // Insert new record
                    $query = "INSERT INTO $tbname (date, uid) VALUES (:date, :uid)";
                } else {
                    $query = "DELETE FROM $tbname WHERE date = :date AND uid = :uid";
                }

                $stmt = $conn->prepare($query);
                $stmt->execute([
                    ':date' => $current_date,
                    ':uid' => $_POST['uid']
                ]);

                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } catch (PDOException $e) {
                echo "<p style='color: red;'>Error updating attendance: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        ?>

        <h2>Daily attendance for teachers</h2>
        <div class="d-flex justify-content-center">
            <hr>
        </div>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $query = "SELECT uid, name FROM tch_dtl WHERE status = :status ORDER BY name";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([':status' => 'active']);

                        while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $query = "SELECT 1 FROM $tbname WHERE date = :date AND uid = :uid";
                            $attendance_stmt = $conn->prepare($query);
                            $attendance_stmt->execute([
                                ':date' => $current_date,
                                ':uid' => $teacher['uid']
                            ]);
                            $attendance_marked = $attendance_stmt->rowCount() > 0;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($teacher['name']) ?></td>
                                <td class="<?= $attendance_marked ? 'present' : 'absent' ?>">
                                    <form method="POST" style="margin: 0;">
                                        <input type="hidden" name="uid" value="<?= htmlspecialchars($teacher['uid']) ?>">
                                        <input type="hidden" name="attendance_action"
                                            value="<?= $attendance_marked ? 'unmark' : 'mark' ?>">
                                        <button type="submit"
                                            class="btn p-0 tick-toggle-btn <?= $attendance_marked ? 'present' : 'absent' ?>">
                                            <?= $attendance_marked ? '❌' : '✔️' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='3' style='color: red;'>Error fetching teachers: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>