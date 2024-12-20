<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report Card</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <style>
        @media print {
            body {
                background-color: white !important;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-3">

        <?php
        if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        // Get student data from POST
        $class = $_POST['class'];
        $rollno = $_POST['rollno'];
        $name = $_POST['name'];
        $guardian = $_POST['guardian'];
        $dob = $_POST['dob'];

        // Define subjects based on class
        $subjects = [
            'Nursery' => ['Bengali/Hindi', 'English', 'Mathematics', 'Drawing', 'PE', 'Music'],
            'KG-I' => ['Bengali/Hindi', 'English', 'Mathematics', 'GK', 'Drawing', 'PE', 'Music'],
            'KG-II' => ['Bengali/Hindi', 'English', 'Mathematics', 'GK', 'Drawing', 'PE', 'Music'],
            'S-I' => ['Bengali/Hindi', 'English', 'Mathematics', 'SST/EVS', 'GK', 'Drawing', 'PE', 'Music'],
            'S-II' => ['Bengali/Hindi', 'English', 'Mathematics', 'SST/EVS', 'GK', 'Drawing', 'PE', 'Music'],
            'S-III' => ['Bengali/Hindi', 'English', 'Mathematics', 'EVS', 'History', 'Geography', 'Science', 'GK', 'Drawing', 'PE', 'Music'],
            'S-IV' => ['Bengali/Hindi', 'English', 'Mathematics', 'EVS', 'History', 'Geography', 'Science', 'GK', 'Drawing', 'PE', 'Music'],
        ];

        // Get subjects for the selected class
        $classSubjects = $subjects[$class] ?? [];
        ?>

        <div class="text-center mb-4">
            <h2>Student Report Card</h2>
            <h3 class="text-center mt-3">ABC School</h3>
            <p class="text-center mb-3"><?php echo "Session: " . date("Y"); ?></p>
            <h4 class="text-center mb-3"><?php echo htmlspecialchars($name); ?></h4>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($class); ?> | <strong>Roll No.:</strong>
                <?php echo htmlspecialchars($rollno); ?></p>
            <p><strong>Guardian:</strong> <?php echo htmlspecialchars($guardian); ?> | <strong>Date of Birth:</strong>
                <?php echo htmlspecialchars($dob); ?></p>
        </div>

        <form id="reportCardForm">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classSubjects as $subject): ?>
                        <tr>
                            <td>
                                <?php if ($subject === 'Bengali/Hindi'): ?>
                                    <select name="subject_choice_bengali_hindi" class="form-select text-center" required>
                                        <option value="">Select Bengali/Hindi</option>
                                        <option value="Bengali">Bengali</option>
                                        <option value="Hindi">Hindi</option>
                                    </select>
                                <?php elseif ($subject === 'SST/EVS'): ?>
                                    <select name="subject_choice_sst_evs" class="form-select text-center" required>
                                        <option value="">Select SST/EVS</option>
                                        <option value="SST">SST</option>
                                        <option value="EVS">EVS</option>
                                    </select>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($subject); ?>
                                <?php endif; ?>
                            </td>
                            <td><input type="number" name="marks[]" class="form-control mark-input" min="0" max="100"
                                    required></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

        <div class="text-center mt-4 mb-4 no-print">
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-primary" onclick="validateAndPrint();">Print Report Card</button>

                <form action="students_db.php" method="POST">
                    <input type="hidden" name="class" value="<?php echo $class; ?>">
                    <button type="submit" class="btn btn-primary">Student List</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        let originalDropdowns = [];

        function replaceDropdownsForPrint() {
            originalDropdowns = [];
            const dropdowns = document.querySelectorAll('select');

            dropdowns.forEach(dropdown => {
                // Save the original dropdown and its parent
                originalDropdowns.push({ parent: dropdown.parentNode, dropdown });

                // Create a span element with the selected value
                const span = document.createElement('span');
                span.textContent = dropdown.value || dropdown.options[0].text;
                span.className = dropdown.className;

                // Style the span to ensure it is centered
                span.style.display = 'inline-block';
                span.style.padding = '0.375rem 0.75rem'; // Padding for centering
                span.style.textAlign = 'center'; // Center the text
                span.style.border = 'none';       // Ensure no border
                span.style.background = 'none';   // Remove background styling

                // Replace the dropdown with the span
                dropdown.parentNode.replaceChild(span, dropdown);
            });
        }

        function restoreDropdownsAfterPrint() {
            originalDropdowns.forEach(item => {
                const { parent, dropdown } = item;
                const span = parent.querySelector('span');
                parent.replaceChild(dropdown, span);
            });
        }

        function validateAndPrint() {
            const marks = document.querySelectorAll('.mark-input');
            const subjectChoiceBengaliHindi = document.querySelector('select[name="subject_choice_bengali_hindi"]');
            const subjectChoiceSSTEVS = document.querySelector('select[name="subject_choice_sst_evs"]');
            let allFilled = true;

            // Check if all marks are filled
            marks.forEach(input => {
                if (input.value.trim() === '') {
                    allFilled = false;
                }
            });

            // Validate Bengali/Hindi dropdown
            if (subjectChoiceBengaliHindi && subjectChoiceBengaliHindi.value === '') {
                alert('Please select Bengali or Hindi before printing the report card.');
                return;
            }

            // Validate SST/EVS dropdown if it exists
            if (subjectChoiceSSTEVS && subjectChoiceSSTEVS.value === '') {
                alert('Please select SST or EVS before printing the report card.');
                return;
            }

            if (!allFilled) {
                alert('Please fill in all the marks before printing the report card.');
            } else {
                window.print();
            }
        }

        // Attach the events for before and after printing
        window.addEventListener('beforeprint', replaceDropdownsForPrint);
        window.addEventListener('afterprint', restoreDropdownsAfterPrint);
    </script>
</body>

</html>