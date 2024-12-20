<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/form.css" rel="stylesheet">
</head>

<?php
function validateInput($data, $minLength, $maxLength, $allowedChars)
{
    $data = trim(stripslashes($data));
    if (strlen($data) < $minLength || strlen($data) > $maxLength) {
        return false;
    }
    // Check if data contains only allowed characters
    if (preg_match("/^[$allowedChars]+$/u", $data)) {
        return true;
    }
    return false;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // prevents JS injection attack
    return $data;
}

$uid = $_POST['uid'];
$class = $_POST['class'];
$rollno = $name = $guardian = $dob = $address = $phone = $email = '';
$msg = '';

if (isset($_POST['rollno']))
    $rollno = test_input($_POST['rollno']);

if (isset($_POST['name']))
    $name = test_input($_POST['name']);

if (isset($_POST['guardian']))
    $guardian = test_input($_POST['guardian']);

if (isset($_POST['dob']))
    $dob = test_input($_POST['dob']);

if (isset($_POST['address']))
    $address = test_input($_POST['address']);

if (isset($_POST['phone']))
    $phone = test_input($_POST['phone']);

if (isset($_POST['email']))
    $email = test_input($_POST['email']);


// Process form submission
if (isset($_POST['register'])) {
    // Validate Roll No. (Only digits, 1-10 characters)
    if (!validateInput($rollno, 1, 10, '0-9_-')) {
        $msg .= '<span style="color: #f44900">Invalid Roll No. format!</span><br>';
    }

    // Validate Name (Only letters and spaces, 1-255 characters)
    if (!validateInput($name, 1, 255, 'A-Za-z\s')) {
        $msg .= '<span style="color: #f44900">Invalid Name format!</span><br>';
    }

    // Validate Guardian's Name (Only letters and spaces, 1-255 characters)
    if (!validateInput($guardian, 1, 255, 'A-Za-z\s')) {
        $msg .= '<span style="color: #f44900">Invalid Guardian\'s Name format!</span><br>';
    }

    // Validate DOB (Date format YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        $msg .= '<span style="color: #f44900">Invalid Date of Birth format!</span><br>';
    }

    // Validate Address (1-500 characters)
    if (!validateInput($address, 1, 255, 'A-Za-z0-9\s,.#-')) {
        $msg .= '<span style="color: #f44900">Invalid Address format!</span><br>';
    }

    // Validate Phone Number (Only digits, 10 characters)
    if (!validateInput($phone, 10, 10, '0-9')) {
        $msg .= '<span style="color: #f44900">Invalid Phone Number format!</span><br>';
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg .= '<span style="color: #f44900">Invalid Email format!</span><br>';
    }

    // If no validation errors, proceed
    if (strlen($msg) < 1) {
        $_SESSION["post"] = $_POST;
        die(header("Location: ./stu_updt_db.php"));
    }
}
?>

<body>
    <?php require '../inc/header.php'; ?>
    <div class="container-fluid text-center">
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Student Registration</h5>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input type="hidden" name="uid" value="<?php echo htmlspecialchars($uid); ?>">
                            <table class="table table-borderless">
                                <tr>
                                    <td><label for="class" class="form-label">Class</label></td>
                                    <td>
                                        <select name="class" class="form-select" required>
                                            <option value="">Select Class</option>
                                            <option value="Nursery" <?php echo (isset($class) && $class == 'Nursery') ? 'selected' : ''; ?>>Nursery</option>
                                            <option value="KG-I" <?php echo (isset($class) && $class == 'KG-I') ? 'selected' : ''; ?>>KG-I</option>
                                            <option value="KG-II" <?php echo (isset($class) && $class == 'KG-II') ? 'selected' : ''; ?>>KG-II</option>
                                            <option value="S-I" <?php echo (isset($class) && $class == 'S-I') ? 'selected' : ''; ?>>S-I</option>
                                            <option value="S-II" <?php echo (isset($class) && $class == 'S-II') ? 'selected' : ''; ?>>S-II</option>
                                            <option value="S-III" <?php echo (isset($class) && $class == 'S-III') ? 'selected' : ''; ?>>S-III</option>
                                            <option value="S-IV" <?php echo (isset($class) && $class == 'S-IV') ? 'selected' : ''; ?>>S-IV</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="rollno" class="form-label">Roll No.</label></td>
                                    <td><input type="text" name="rollno" class="form-control"
                                            value="<?php echo $rollno ?>" required></td>
                                </tr>
                                <tr>
                                    <td><label for="name" class="form-label">Name</label></td>
                                    <td><input type="text" name="name" class="form-control" value="<?php echo $name ?>"
                                            required></td>
                                </tr>
                                <tr>
                                    <td><label for="guardian" class="form-label">Guardian's Name</label></td>
                                    <td><input type="text" name="guardian" class="form-control"
                                            value="<?php echo $guardian ?>" required></td>
                                </tr>
                                <tr>
                                    <td><label for="dob" class="form-label">Date of Birth</label></td>
                                    <td><input type="date" name="dob" class="form-control" value="<?php echo $dob ?>"
                                            required></td>
                                </tr>
                                <tr>
                                    <td><label for="address" class="form-label">Address</label></td>
                                    <td><textarea name="address" class="form-control" rows="3"
                                            required><?php echo $address ?></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="phone" class="form-label">Phone No.</label></td>
                                    <td><input type="text" name="phone" class="form-control"
                                            value="<?php echo $phone ?>" required></td>
                                </tr>
                                <tr>
                                    <td><label for="email" class="form-label">Email</label></td>
                                    <td><input type="email" name="email" class="form-control"
                                            value="<?php echo $email ?>" required></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-danger">
                                        <?php echo $msg; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><!-- filler --></td>
                                    <td><button type="submit" name="register" class="btn btn-primary">Confirm
                                            Edit</button>
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>