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
    $firstName = sanitize($_POST['firstName']);
    $lastName = sanitize($_POST['lastName']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirmPassword = sanitize($_POST['confirmPassword']);
    $membershipID = sanitize($_POST['membershipID']);
    $rfid = sanitize($_POST['rfid']);
    $birthday = sanitize($_POST['birthday']);

    // Check membership requirement.
    $membershipQuery = "SELECT requirement FROM memberships WHERE membershipID = '$membershipID'";
    $membershipResult = executeQuery($membershipQuery);
    $membershipRequirement = mysqli_fetch_assoc($membershipResult);
    $duration = (int) filter_var($membershipRequirement['requirement'], FILTER_SANITIZE_NUMBER_INT);

    // Calculate start and end dates based on membership requirement.
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime("+$duration days"));


    // Check if email already exists.
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = executeQuery($checkEmailQuery);

    // Check if RFID already exists.
    $checkRfidQuery = "SELECT * FROM users WHERE rfidNumber = '$rfid'";
    $checkRfidResult = executeQuery($checkRfidQuery);

    // Check if user with the same first name and last name already exists.
    $checkNameQuery = "SELECT * FROM users WHERE firstName = '$firstName' AND lastName = '$lastName'";
    $checkNameResult = executeQuery($checkNameQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $emailExistsError = "emailExists";
    } elseif (mysqli_num_rows($checkRfidResult) > 0) {
        $rfidExistsError = "rfidExists";
    } elseif (mysqli_num_rows($checkNameResult) > 0) {
        $firstNameError = "duplicateName";
        $lastNameError = "duplicateName";
    } else {
        $user = new User(null, $firstName, $lastName, $email, $password, $rfid, $birthday);

        // Register the new user.
        if ($user->RegisterUser($membershipID, $startDate, $endDate)) {
            $lastInsertedID = mysqli_insert_id($conn);
            $_SESSION['userCreated'] = true;
            header("Location: users.php?register=success");
            exit();
        }
    }
}
?>