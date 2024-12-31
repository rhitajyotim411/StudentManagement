<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routine</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/tick.css" rel="stylesheet">

    <style>
        input:disabled {
            background-color: white !important;
            color: black;
        }

        input:not(:disabled) {
            border-color: red;
        }

        #successAlert {
            z-index: 1050;
            /* Ensures alert stays above other content */
        }

        @media (max-width: 767px) {
            input[type="text"] {
                width: 100% !important;
                min-width: 150px;
                /* Optional, you can adjust the minimum width */
            }
        }
    </style>

    <script>
        function toggleEditMode() {
            const formFields = document.querySelectorAll('input[type="text"]');
            const toggleButton = document.getElementById('toggleEditButton');
            const saveButton = document.getElementById('saveRoutineButton');
            const isEditMode = toggleButton.dataset.mode === 'edit';

            // Toggle the disabled attribute for fields
            formFields.forEach(field => field.disabled = isEditMode);

            // Toggle the disabled state of the save button
            saveButton.disabled = isEditMode;

            // Update button label and data attribute
            toggleButton.textContent = isEditMode ? 'Edit' : 'View';
            toggleButton.dataset.mode = isEditMode ? 'view' : 'edit';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const alertElement = document.getElementById('successAlert');
            if (alertElement) {
                setTimeout(() => {
                    alertElement.style.transition = 'opacity 1s';
                    alertElement.style.opacity = '0';
                    setTimeout(() => alertElement.remove(), 1000);
                }, 5000);
            }
        });
    </script>
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

        // Fetch classes for dropdown
        $classes = ['Nursery', 'KG-I', 'KG-II', 'S-I', 'S-II', 'S-III', 'S-IV'];
        $selectedClass = $_GET['class'] ?? 'Nursery';

        // Fetch routine for the selected class
        $stmt = $conn->prepare("SELECT * FROM class_routine WHERE class_name = ?");
        $stmt->execute([$selectedClass]);
        $routine = $stmt->fetch(PDO::FETCH_ASSOC);

        // Handle routine update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['routine'] as $key => $value) {
                $routine[$key] = $value; // Update local routine
            }
            // Build update query
            $updateQuery = "UPDATE class_routine SET " . implode(", ", array_map(fn($key) => "$key = ?", array_keys($_POST['routine']))) . " WHERE class_name = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->execute(array_merge(array_values($_POST['routine']), [$selectedClass]));
            echo "<div id='successAlert' class='alert alert-primary fixed-bottom text-center mb-0'>Routine updated successfully!</div>";
        }
        ?>

        <form method="GET" class="mb-3">
            <label for="classSelect" class="form-label">Select Class:</label>
            <select id="classSelect" name="class" class="form-select w-auto d-inline" onchange="this.form.submit()">
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class ?>" <?= $class === $selectedClass ? 'selected' : '' ?>><?= $class ?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($routine): ?>
            <form method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day/Period</th>
                                <th>Period 1</th>
                                <th>Period 2</th>
                                <th>Period 3</th>
                                <th>Period 4</th>
                                <th>Period 5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                            foreach ($days as $day): ?>
                                <tr>
                                    <td><?= ucfirst($day) ?></td>
                                    <?php for ($i = 1; $i <= 5; $i++):
                                        $field = "{$day}_period{$i}";
                                        ?>
                                        <td>
                                            <input type="text" class="form-control" name="routine[<?= $field ?>]"
                                                value="<?= htmlspecialchars($routine[$field] ?? '') ?>" disabled>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button type="button" id="toggleEditButton" class="btn btn-warning" onclick="toggleEditMode()"
                        data-mode="view">Edit</button>
                    <button type="submit" id="saveRoutineButton" class="btn btn-primary" disabled>Save Routine</button>
                </div>
            </form>
        <?php else: ?>
            <p>No routine found for the selected class.</p>
        <?php endif; ?>
    </div>
</body>

</html>