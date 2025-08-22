<?php
// session verification (check ID and email)
if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = "";
}

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "";
}

$userID = $_SESSION['userID'];
$email = $_SESSION['email'];

// if no ID, redirect to login page
if (empty($userID)) {
    header("Location: ../login.php");
    exit;
}

$profileUpdated = false;
$userInfoArray = array();
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $userInfoQuery = "
    SELECT *
    FROM users u
    WHERE u.state = 'Active' AND u.role = 'admin'
      AND u.userID = $userID

    ";
}
$userInfoResult = executeQuery($userInfoQuery);
if (mysqli_num_rows($userInfoResult) > 0) {
    $userInfoArray = mysqli_fetch_assoc($userInfoResult);
}

if (isset($_POST['btnSaveInfo'])) {
    $firstName = ucwords(strtolower($_POST['firstName']));
    $lastName = ucwords(strtolower($_POST['lastName']));
    $userID = $_SESSION['userID'];

    $updateInfoQuery = "UPDATE users SET firstName = '$firstName',
    lastName = '$lastName'
    WHERE userID = $userID";

    executeQuery($updateInfoQuery);
    $_SESSION['profileUpdated'] = true;
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

if (isset($_POST['btnSaveAccInfo'])) {
    // Store user inputs in session if errors occur
    $_SESSION['currentPass'] = $_POST['currentPass'] ?? '';
    $_SESSION['newPass'] = $_POST['newPass'] ?? '';
    $_SESSION['confirmPass'] = $_POST['confirmPass'] ?? '';

    $userID = $_SESSION['userID'] ?? null;

    $email = trim($_POST['email'] ?? '');
    $currentPass = trim($_POST['currentPass'] ?? '');
    $newPass = $_POST['newPass'] ?? '';
    $confirmPass = $_POST['confirmPass'] ?? '';


    $isChangingEmail = !empty($email);
    $isEnteringCurrentPassword = !empty($currentPass);
    $isChangingPassword = !empty($newPass) || !empty($confirmPass);

    $updateFields = [];

    // Password validation
    if ($isEnteringCurrentPassword || $isChangingPassword) {
        if (strlen($currentPass) < 8) {
            $_SESSION['currentPasswordError'] = "Current password must be correct.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }

        $getPasswordQuery = "SELECT password FROM users WHERE userID = $userID";
        $getPasswordResult = executeQuery($getPasswordQuery);
        $user = mysqli_fetch_assoc($getPasswordResult);

        if (!$user || !password_verify($currentPass, $user['password'])) {
            $_SESSION['currentPasswordError'] = "Current password is incorrect.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }
        if (password_verify($newPass, $user['password'])) {
            $_SESSION['currentPasswordError'] = "New password cannot be the same as your current password.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }

        if ($isChangingPassword) {
            if ($newPass !== $confirmPass) {
                $_SESSION['currentPasswordError'] = "New password and confirm password do not match.";
                header("Location: {$_SERVER['PHP_SELF']}");
                exit;
            }
            $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
            $updateFields[] = "password = '$hashedNewPass'";
        }
    }

    // Email validation
    if ($isChangingEmail) {
        $sanitizedEmail = mysqli_real_escape_string($conn, $email);
        $checkEmailQuery = "SELECT userID FROM users WHERE email = '$sanitizedEmail' AND userID != $userID";
        $checkEmailResult = executeQuery($checkEmailQuery);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            $_SESSION['emailInputError'] = "An account already exists with this email.";
            $_SESSION['oldEmailInput'] = $email;
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }

        $updateFields[] = "email = '$sanitizedEmail'";
    }

    if (!empty($updateFields)) {
        $updateQuery = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE userID = $userID";
        $updateResult = executeQuery($updateQuery);

        if ($updateResult) {
            unset($_SESSION['currentPass']);
            unset($_SESSION['newPass']);
            unset($_SESSION['confirmPass']);
            $_SESSION['accountUpdated'] = true;
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

if (isset($_POST['btnCloseDelete'])) {
    $deleteAccQuery = "DELETE FROM users WHERE userID = $userID";
    executeQuery($deleteAccQuery);
    session_unset();
    session_destroy();

    header("Location: ../login.php");
    exit;
}

