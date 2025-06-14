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

if (isset($_POST['btnRegister'])) {
    $firstName = sanitize($_POST['firstName']);
    $lastName = sanitize($_POST['lastName']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirmPassword = sanitize($_POST['confirmPassword']);
    $membershipID = sanitize($_POST['membershipID']);

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

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $emailExistsError = "emailExists";
    } else {
        $user = new User(null, $firstName, $lastName, $email, $password);

        // Register the new user.
        if ($user->RegisterUser($membershipID, $startDate, $endDate)) {
            $lastInsertedID = mysqli_insert_id($conn);
               $_SESSION['userCreated'] = true;
            header("Location: users.php");
            exit();
        } 
    }
}
?>
