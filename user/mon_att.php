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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/heatmap.css" rel="stylesheet">
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

        $tbname = "stu_att";
        $classes = ['Nursery', 'KG-I', 'KG-II', 'S-I', 'S-II', 'S-III', 'S-IV'];
        $current_year = date('Y');
        $selected_year = $_GET['year'] ?? $current_year;
        $year_range = range($current_year - 5, $current_year);

        // Find the global maximum attendance across all years
        try {
            $max_query = "SELECT COUNT(*) as total
                         FROM $tbname
                         WHERE YEAR(date) >= :min_year
                         AND YEAR(date) <= :max_year
                         GROUP BY class, YEAR(date), MONTH(date)
                         ORDER BY total DESC
                         LIMIT 1";
            $stmt = $conn->prepare($max_query);
            $stmt->execute([
                ':min_year' => min($year_range),
                ':max_year' => max($year_range)
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $global_max_attendance = $result ? $result['total'] : 0;
        } catch (PDOException $e) {
            $global_max_attendance = 0;
            echo "<div class='alert alert-danger'>Error finding maximum attendance: " .
                htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>

        <form method="GET" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-auto">
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

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                        <?php foreach (range(1, 12) as $month): ?>
                            <th><?= date('M', mktime(0, 0, 0, $month, 1)) ?></th>
                        <?php endforeach; ?>
                        <th>Year Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $monthly_totals = array_fill(1, 12, 0);
                        $year_total = 0;

                        foreach ($classes as $class) {
                            echo "<tr><td><strong>" . htmlspecialchars($class) . "</strong></td>";
                            $class_total = 0;

                            foreach (range(1, 12) as $month) {
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

                                $monthly_totals[$month] += $total_attendance;
                                $class_total += $total_attendance;

                                echo "<td data-value='" . $total_attendance . "' data-max='" . $global_max_attendance . "'>"
                                    . htmlspecialchars($total_attendance) . "</td>";
                            }

                            $year_total += $class_total;
                            echo "<td class='year-total'>" . htmlspecialchars($class_total) . "</td></tr>";
                        }

                        // Add monthly totals row
                        echo "<tr class='table-secondary'><td><strong>Monthly Total</strong></td>";
                        foreach ($monthly_totals as $total) {
                            echo "<td><strong>" . htmlspecialchars($total) . "</strong></td>";
                        }
                        echo "<td><strong>" . htmlspecialchars($year_total) . "</strong></td></tr>";
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='14' style='color: red;'>Error fetching attendance: "
                            . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Legend with max value -->
        <div class="legend">
            <span>Low (0)</span>
            <div class="legend-gradient"></div>
            <span>High (<?= htmlspecialchars($global_max_attendance) ?>)</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to interpolate between two colors
            function interpolateColor(color1, color2, factor) {
                const r1 = parseInt(color1.slice(1, 3), 16);
                const g1 = parseInt(color1.slice(3, 5), 16);
                const b1 = parseInt(color1.slice(5, 7), 16);

                const r2 = parseInt(color2.slice(1, 3), 16);
                const g2 = parseInt(color2.slice(3, 5), 16);
                const b2 = parseInt(color2.slice(5, 7), 16);

                const r = Math.round(r1 + (r2 - r1) * factor);
                const g = Math.round(g1 + (g2 - g1) * factor);
                const b = Math.round(b1 + (b2 - b1) * factor);

                return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            }

            // Apply colors to cells
            const cells = document.querySelectorAll('td[data-value]');
            const lowColor = '#FFB6C6';  // Pink
            const highColor = '#90EE90'; // Light green

            cells.forEach(cell => {
                const value = parseFloat(cell.dataset.value);
                const max = parseFloat(cell.dataset.max);
                const factor = max > 0 ? value / max : 0;

                const backgroundColor = interpolateColor(lowColor, highColor, factor);
                cell.style.backgroundColor = backgroundColor;
                cell.style.color = 'black';
            });
        });
    </script>
</body>

</html>