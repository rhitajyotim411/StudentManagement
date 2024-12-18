<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Register</title>
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

$msg = '';

// If user has given a captcha!
if (isset($_POST['captcha']) && isset($_POST['submit']) && $_POST['captcha'] != '')
    // If the captcha is valid
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        // form validation
        if (isset($_POST['uid'])) {
            $flag = validateInput($_POST['uid'], 1, 10, 'A-Za-z0-9');
            if (!$flag) {
                if (strlen($msg) > 0)
                    $msg .= '<br/>';
                $msg .= '<span style="color: #f44900">Invalid Staff ID format!</span>';
            }
        }
        if (isset($_POST['name'])) {
            $flag = validateInput($_POST['name'], 1, 255, "A-Za-z'. ");
            if (!$flag) {
                if (strlen($msg) > 0)
                    $msg .= '<br/>';
                $msg .= '<span style="color: #f44900">Invalid Name format!</span>';
            }
        }
        if (isset($_POST['passwd'])) {
            $flag = validateInput($_POST['passwd'], 5, 255, 'A-Za-z0-9_@');
            if (!$flag) {
                if (strlen($msg) > 0)
                    $msg .= '<br/>';
                $msg .= '<span style="color: #f44900">Invalid Password format!</span>';
            }
        }
        if (strlen($msg) < 1) {
            $_SESSION["post"] = $_POST;
            die(header("Location: ./register_db.php"));
        }
    } else {
        $msg = '<span style="color: #f44900">CAPTCHA FAILED!!!</span>';
    }

$uid = $name = $passwd = "";

if (isset($_POST['uid']))
    $uid = test_input($_POST['uid']);
if (isset($_POST['name']))
    $name = test_input($_POST['name']);
if (isset($_POST['passwd']))
    $passwd = test_input($_POST['passwd']);
?>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center">
        <?php
        if (isset($_SESSION['UID'])) {
            echo "{$_SESSION['UID']} already logged in<br>";
            echo "Redirecting to dashboard...";
            die(header("refresh:2; URL=../{$_SESSION['type']}/dashboard.php"));
        }
        ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Staff registration</h5>
                        <p class="card-text">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="d-flex justify-content-center">
                                <div class="overflow-auto">
                                    <table>
                                        <tr>
                                            <td><label for="uid">Staff ID: </label></td>
                                            <td><input name="uid" type="text" length="10" maxlength="10"
                                                    value="<?php echo $uid ?>"></td>
                                            <td>
                                                <div class="dropend">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-info-circle" style="font-size:20px"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li class="dropdown-item-text">Max. length 10</li>
                                                        <li class="dropdown-item-text">Alphabets, Numbers only</li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="name">Full Name: </label></td>
                                            <td><input name="name" type="text" length="100" maxlength="255"
                                                    value="<?php echo $name ?>"></td>
                                            <td><!-- Filler --></td>
                                        </tr>
                                        <tr>
                                            <td><label for="passwd">Password: </label></td>
                                            <td><input name="passwd" type="password" length="100" maxlength="255"
                                                    value="<?php echo $passwd ?>"></td>
                                            <td>
                                                <div class="dropend">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-info-circle" style="font-size:20px"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li class="dropdown-item-text">Min. length 5</li>
                                                        <li class="dropdown-item-text">Max. length 255</li>
                                                        <li class="dropdown-item-text">Alphabets, Numbers, @, _ only
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img id="captch" src="../inc/captcha.php"></td>
                                            <td><input type="submit" class="btn btn-primary" value="Refresh"></td>
                                            <td><!-- Filler --></td>
                                        </tr>
                                        <tr>
                                            <td><label for="captcha" name="captcha">Captcha: </label></td>
                                            <td><input type="text" name="captcha" autocomplete="off" /></td>
                                            <td><!-- Filler --></td>
                                        </tr>
                                        <tr>
                                            <td><!-- Filler --></td>
                                            <td>
                                                <?php echo $msg; ?>
                                            </td>
                                            <td><!-- Filler --></td>
                                        </tr>
                                        <tr>
                                            <td><!-- Filler --></td>
                                            <td><input type="submit" name="submit" class="btn btn-primary"
                                                    value="Verify">
                                            </td>
                                            <td><!-- Filler --></td>
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