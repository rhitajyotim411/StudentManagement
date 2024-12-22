<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!-- Previous head content remains the same -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
    <link href="../style/fees.css" rel="stylesheet">
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
        require_once '../inc/connect.php';

        // Handle fee toggle submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fee_action'])) {
            try {
                if ($_POST['fee_action'] === 'add') {
                    $query = "INSERT INTO fees (year, month, uid) VALUES (:year, :month, :uid)";
                } else {
                    $query = "DELETE FROM fees WHERE year = :year AND month = :month AND uid = :uid";
                }

                $stmt = $conn->prepare($query);
                $stmt->execute([
                    ':year' => $_POST['year'],
                    ':month' => $_POST['month'],
                    ':uid' => $_POST['uid']
                ]);

                header("Location: {$_SERVER['PHP_SELF']}?year={$_POST['year']}&class={$_POST['class']}&edit_month={$_POST['month']}");
                exit();
            } catch (PDOException $e) {
                echo "Error updating fee status: " . $e->getMessage();
            }
        }

        $current_year = date('Y');
        $current_month = date('n');
        $selected_year = isset($_GET['year']) ? $_GET['year'] : $current_year;
        $selected_class = isset($_GET['class']) ? $_GET['class'] : 'Nursery';
        $active_month = isset($_GET['edit_month']) ? $_GET['edit_month'] : $current_month;

        $years = range($current_year - 2, $current_year);
        $classes = ['Nursery', 'KG-I', 'KG-II', 'S-I', 'S-II', 'S-III', 'S-IV'];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        ?>

        <h2>Fee Details for <?php echo "{$selected_class}, {$selected_year}" ?></h2>

        <!-- Filter Form - remains the same -->
        <form method="GET" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= $year == $selected_year ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <select name="class" class="form-select" onchange="this.form.submit()">
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class ?>" <?= $class == $selected_class ? 'selected' : '' ?>>
                                <?= $class ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Fees Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <?php foreach ($months as $index => $month): ?>
                            <th><?= $month ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $query = "SELECT uid, rollno, name FROM stu_dtl WHERE class = :class ORDER BY rollno";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([':class' => $selected_class]);

                        while ($student = $stmt->fetch(PDO::FETCH_ASSOC)):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($student['rollno']) ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <?php
                                for ($m = 1; $m <= 12; $m++):
                                    try {
                                        $query = "SELECT 1 FROM fees WHERE year = :year AND month = :month AND uid = :uid";
                                        $fee_stmt = $conn->prepare($query);
                                        $fee_stmt->execute([
                                            ':year' => $selected_year,
                                            ':month' => $m,
                                            ':uid' => $student['uid']
                                        ]);
                                        $fee_paid = $fee_stmt->rowCount() > 0;

                                        if ($selected_year == $current_year) {
                                            $cell_class = ($m == $current_month) ?
                                                ($fee_paid ? 'paid' : 'current-unpaid') :
                                                (($m < $current_month && $fee_paid) ? 'paid' : ($m < $current_month ? 'unpaid' : ''));
                                        } else if ($selected_year < $current_year) {
                                            $cell_class = $fee_paid ? 'paid' : 'unpaid';
                                        } else {
                                            $cell_class = '';
                                        }
                                        ?>
                                        <td class="<?= $cell_class ?>">
                                            <form method="POST" style="margin:0;">
                                                <input type="hidden" name="year" value="<?= $selected_year ?>">
                                                <input type="hidden" name="month" value="<?= $m ?>">
                                                <input type="hidden" name="uid" value="<?= $student['uid'] ?>">
                                                <input type="hidden" name="class" value="<?= $selected_class ?>">
                                                <input type="hidden" name="fee_action" value="<?= $fee_paid ? 'delete' : 'add' ?>">
                                                <button type="submit"
                                                    class="btn p-0 fee-toggle-btn <?= $fee_paid ? 'paid' : 'unpaid' ?>">
                                                    <?= $fee_paid ? '❌' : '✔️' ?>
                                                </button>

                                            </form>
                                        </td>
                                        <?php
                                    } catch (PDOException $e) {
                                        echo "<td>Error: " . $e->getMessage() . "</td>";
                                    }
                                endfor;
                                ?>
                            </tr>
                            <?php
                        endwhile;
                    } catch (PDOException $e) {
                        echo "Error fetching students: " . $e->getMessage();
                        echo "<br><a class=\"ref\" href='../index.php'>Homepage</a>";
                        die();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>