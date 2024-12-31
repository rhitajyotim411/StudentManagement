<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/IDcard.css" rel="stylesheet">
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

        $uid = $_POST['uid'];
        $class = $_POST['class'];
        $rollno = $_POST['rollno'];
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];
        ?>

        <div class="text-center mb-4">
            <h2>Student ID Card</h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="id-card" id="idCard">
                <h4 class="text-center mb-3">ABC School</h4>
                <p class="text-center mb-3"><?php echo "Session: " . date("Y"); ?></p>

                <div class="id-details">
                    <img id="photoPreview" src="" alt="Photo" class="d-none">
                    <div class="info">
                        <p><strong>Name:</strong> <?php echo $name ?></p>
                        <p><strong>Class:</strong> <?php echo $class ?></p>
                        <p><strong>Roll No.:</strong> <?php echo $rollno ?></p>
                        <p><strong>DOB:</strong> <?php echo $dob ?></p>
                        <p><strong>Phone:</strong> <?php echo $phone ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 no-print">
            <input type="file" id="photoUpload" class="form-control btn-upload" accept="image/*">

            <div class="d-flex justify-content-center gap-2 mt-3">
                <button id="printBtn" class="btn btn-success" onclick="window.print()" disabled>Print ID Card</button>

                <form action="stu_dtl.php" method="POST">
                    <input type="hidden" name="stu_id" value="<?php echo $uid; ?>">
                    <button type="submit" class="btn btn-primary">Student details</button>
                </form>

                <form action="students_db.php" method="POST">
                    <input type="hidden" name="class" value="<?php echo $class; ?>">
                    <button type="submit" class="btn btn-primary">Student List</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const photoUpload = document.getElementById('photoUpload');
        const photoPreview = document.getElementById('photoPreview');
        const printBtn = document.getElementById('printBtn');

        photoUpload.addEventListener('change', function () {
            const file = photoUpload.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                    photoPreview.classList.remove('d-none');
                    printBtn.disabled = false;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>