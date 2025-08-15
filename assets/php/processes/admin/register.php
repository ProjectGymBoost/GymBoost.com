<?php
session_start();

// Function to sanitize user inputs. 
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$emailExistsError = "";
$rfidExistsError = "";
$lastNameError = "";
$firstNameError = "";

if (isset($_POST['btnRegister'])) {
    $role = sanitize($_POST['accountSelect']);
    $firstName = ucwords(strtolower(sanitize($_POST['firstName'])));
    $lastName = ucwords(strtolower(sanitize($_POST['lastName'])));
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirmPassword = sanitize($_POST['confirmPassword']);
    $birthday = sanitize($_POST['birthday']);

    if ($role === "admin") {
        $rfid = null;
        $membershipID = $startDate = $endDate = null;
        $checkRfidResult = null;
    } else {
        $rfid = sanitize($_POST['rfid']);
        $membershipID = sanitize($_POST['membershipID']);

        $membershipResult = executeQuery("
            SELECT requirement 
            FROM memberships 
            WHERE membershipID = '$membershipID'");
        $requirement = mysqli_fetch_assoc($membershipResult)['requirement'];
        $duration = (int) filter_var($requirement, FILTER_SANITIZE_NUMBER_INT);
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+$duration days"));

        $checkRfidResult = executeQuery("SELECT * FROM users WHERE rfidNumber = '$rfid'");
    }

    $checkEmailResult = executeQuery("SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $emailExistsError = ($role === 'admin') ? 'adminEmailExists' : 'userEmailExists';
    }

    if ($role === "user" && $rfid && mysqli_num_rows($checkRfidResult) > 0) {
        $rfidExistsError = "userRfidExists";
    }

    if (!$emailExistsError && !$rfidExistsError && $password === $confirmPassword) {
        $user = new User(null, $firstName, $lastName, $email, $password, $rfid, $birthday);

        if ($user->RegisterUser($role, $membershipID, $startDate, $endDate)) {
            $_SESSION['userCreated'] = true;
            $_SESSION['createdUserRole'] = $role;
            header("Location: users.php?register=success");
            exit;
        }
    }
}
?>