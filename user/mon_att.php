<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Attendance</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
    <style>
        table th,
        table td {
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        table th {
            font-weight: bold;
        }
    </style>
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

        $tbname = "attdnc";
        $classes = ['Nursery', 'KG-I', 'KG-II', 'S-I', 'S-II', 'S-III', 'S-IV'];
        $current_year = date('Y');
        $selected_year = $_GET['year'] ?? $current_year;

        // Generate years for dropdown
        $year_range = range($current_year - 5, $current_year);
        ?>

        <!-- Year Selection Dropdown -->
        <form method="GET" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <label for="year" class="form-label">Select Year:</label>
                    <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                        <?php foreach ($year_range as $year): ?>
                            <option value="<?= htmlspecialchars($year) ?>" <?= $year == $selected_year ? 'selected' : '' ?>>
                                <?= htmlspecialchars($year) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                        <?php foreach (range(1, 12) as $month): ?>
                            <th><?= date('M', mktime(0, 0, 0, $month, 1)) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        foreach ($classes as $class) {
                            echo "<tr><td><strong>" . htmlspecialchars($class) . "</strong></td>";
                            foreach (range(1, 12) as $month) {
                                // Fetch total attendance for the class and month
                                $query = "SELECT COUNT(*) AS total FROM $tbname
                                          WHERE class = :class
                                          AND YEAR(date) = :year
                                          AND MONTH(date) = :month";
                                $stmt = $conn->prepare($query);
                                $stmt->execute([
                                    ':class' => $class,
                                    ':year' => $selected_year,
                                    ':month' => $month
                                ]);
                                $total_attendance = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
                                echo "<td>" . htmlspecialchars($total_attendance) . "</td>";
                            }
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='13' style='color: red;'>Error fetching attendance: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>