<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../../../shared/connect.php');
include(__DIR__ . '/../../../shared/phpmailer/src/Exception.php');
include(__DIR__ . '/../../../shared/phpmailer/src/PHPMailer.php');
include(__DIR__ . '/../../../shared/phpmailer/src/SMTP.php');


$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);


$errors = array();

// Step 1: User submits email for password reset
if (isset($_POST['btnContinue']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
    $checkEmailResult = executeQuery($checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $user = mysqli_fetch_assoc($checkEmailResult);
        $fullName = $user['firstName'] . ' ' . $user['lastName'];
        $code = rand(111111, 999999);
        $insertCodeQuery = "UPDATE users SET code = $code WHERE email = '$email'";
        $insertCodeResult = executeQuery($insertCodeQuery);

        if ($insertCodeResult) {
            $subject = "Your One-Time Password (OTP)";
            $message = "
                        <p>Hi " . htmlspecialchars($fullName) . ",</p>

                        <p>Your one-time password (OTP) is:</p>

                        <p><strong>$code</strong></p>

                        <p>Please enter this OTP to proceed. If you did not request this, please ignore this message or contact support immediately.</p>

                        <p>Thanks,<br>Hard Body Fitness Gym</p>

                        ";


            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'hardbodyfitnessgym13@gmail.com';
                $mail->Password = 'vfko hohl crbg lgid';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('hardbodyfitnessgym13@gmail.com', 'Hard Body Fitness Gym');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();

                $_SESSION['info'] = "We've sent a password reset OTP to your email - $email";
                $_SESSION['email'] = $email;
                header('Location: reset-code.php');
                exit();
            } catch (Exception $e) {
                $errors['otp-error'] = "Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['db-error'] = "Something went wrong.";
        }
    } else {
        $errors['email'] = "This email address does not exist.";
    }
}

// Step 2: User submits OTP
if (isset($_POST['btnReset'])) {
    $_SESSION['info'] = "";
    $otpCode = $_POST['otp'];
    $checkOTPQuery = "SELECT * FROM users WHERE code = $otpCode";
    $checkOTPResult = executeQuery($checkOTPQuery);

    if (mysqli_num_rows($checkOTPResult) > 0) {
        $otpData = mysqli_fetch_assoc($checkOTPResult);
        $email = $otpData['email'];
        $_SESSION['email'] = $email;

        $_SESSION['info'] = "Please create a new password that you don't use on any other site.";
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp'] = "You've an entered incorrect code.";
    }
}

// Step 3: User submits new password
if (isset($_POST['btnChange'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['confirmPassword'];

    if ($password === $cpassword) {
        $email = $_SESSION['email'] ?? null;

        if ($email) {
            $code = 0;
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET code = ?, password = ? WHERE email = ?");

            if ($stmt) {
                $stmt->bind_param("iss", $code, $hashedPassword, $email);
                if ($stmt->execute()) {
                    if ($stmt->execute()) {
                        header('Location: password-changed.php');
                        session_destroy();
                        exit();
                    }
                } else {
                    $errors['db-error'] = "Failed to change your password!";
                }
                $stmt->close();
            } else {
                $errors['db-error'] = "Something went wrong with the statement.";
            }
        }
    } 
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

}

// FOR USER SETTINGS
// Logic for email change
if (isset($_POST['btnEmail'])) {
    $newEmail = trim($_POST['verifyEmail']);
    $userID = $_SESSION['userID'] ?? null;

    if (!$userID) {
        $_SESSION['error'] = "User session expired.";
        header("Location: settings.php");
        exit();
    }
    // Get full name of current user 
    $getCurrentUserQuery = "SELECT firstName, lastName FROM users WHERE userID='$userID'";
    $currentUserResult = executeQuery($getCurrentUserQuery);

    if (mysqli_num_rows($currentUserResult) > 0) {
        $currentUser = mysqli_fetch_assoc($currentUserResult);
        $fullName = $currentUser['firstName'] . ' ' . $currentUser['lastName'];
    } else {
        $fullName = 'Valued User';
    }

    // Validate email format
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailInputError'] = "Invalid email format.";
        $_SESSION['oldEmailInput'] = $newEmail;
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: index.php?page=profile");
        exit();
    }

    // Check if the new email is already taken
    $checkEmailQuery = "SELECT * FROM users WHERE email='$newEmail'";
    $checkEmailResult = executeQuery($checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $user = mysqli_fetch_assoc($checkEmailResult);

        $_SESSION['emailInputError'] = "This email is already in use.";
        $_SESSION['oldEmailInput'] = $newEmail;
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: index.php?page=profile");
        exit();
    }

    $otpCode = rand(111111, 999999);
    $_SESSION['otp_code'] = $otpCode;
    $_SESSION['pending_email'] = $newEmail;

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hardbodyfitnessgym13@gmail.com';
        $mail->Password = 'vfko hohl crbg lgid';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('hardbodyfitnessgym13@gmail.com', 'Hard Body Fitness Gym');
        $mail->addAddress($newEmail);
        $mail->isHTML(true);
        $mail->Subject = "Email Verification OTP";
        $mail->Body = "<p>Hi " . htmlspecialchars($fullName) . ",</p>

                        <p>Your one-time password (OTP) is:</p>

                        <p><strong>$otpCode</strong></p>

                        <p>Please enter this OTP to proceed with email change. If you did not request this, please ignore this message or contact support immediately.</p>

                        <p>Thanks,<br>Hard Body Fitness Gym</p>

                        ";

        $mail->send();
        $_SESSION['show_modal'] = 'otpModal';
        header("Location: index.php?page=profile");
        exit();
    } catch (Exception $e) {
        $_SESSION['emailInputError'] = "Failed to send OTP. Try again.";
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: index.php?page=profile");
        exit();
    }
}

if (isset($_POST['btnConfirmPass'])) {
    $enteredOtp = $_POST['enteredOTP'];
    $sessionOtp = $_SESSION['otp_code'] ?? null;
    $newEmail = $_SESSION['pending_email'] ?? null;
    $userID = $_SESSION['userID'] ?? null;

    if ($enteredOtp == $sessionOtp && $newEmail && $userID) {
        $checkOTPQuery = "UPDATE users SET email = '$newEmail', code = NULL WHERE userID = $userID";
        $checkOTPResult = executeQuery($checkOTPQuery);

        // Clear session data
        unset($_SESSION['otp_code'], $_SESSION['pending_email']);
        $_SESSION['show_modal'] = 'confirmEditEmailInfoModal';
        header("Location: index.php?page=profile");
        exit();
    } elseif ($enteredOtp !== $sessionOtp) {
        // OTP is incorrect
        $_SESSION['otpError'] = "The OTP you entered is incorrect. Please try again.";
        $_SESSION['show_modal'] = 'otpModal';
        header("Location: index.php?page=profile");
    }
}

// FOR ADMIN SETTINGS
// Logic for email change
if (isset($_POST['btnAdminEmail'])) {
    $newEmail = trim($_POST['verifyEmail']);
    $userID = $_SESSION['userID'] ?? null;

    if (!$userID) {
        $_SESSION['error'] = "User session expired.";
        header("Location: settings.php");
        exit();
    }
    // Get full name of current user 
    $getCurrentUserQuery = "SELECT firstName, lastName FROM users WHERE userID='$userID'";
    $currentUserResult = executeQuery($getCurrentUserQuery);

    if (mysqli_num_rows($currentUserResult) > 0) {
        $currentUser = mysqli_fetch_assoc($currentUserResult);
        $fullName = $currentUser['firstName'] . ' ' . $currentUser['lastName'];
    } else {
        $fullName = 'Valued User';
    }

    // Validate email format
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailInputError'] = "Invalid email format.";
        $_SESSION['oldEmailInput'] = $newEmail;
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    // Check if the new email is already taken
    $checkEmailQuery = "SELECT * FROM users WHERE email='$newEmail'";
    $checkEmailResult = executeQuery($checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $user = mysqli_fetch_assoc($checkEmailResult);

        $_SESSION['emailInputError'] = "This email is already in use.";
        $_SESSION['oldEmailInput'] = $newEmail;
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    $otpCode = rand(111111, 999999);
    $_SESSION['otp_code'] = $otpCode;
    $_SESSION['pending_email'] = $newEmail;

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hardbodyfitnessgym13@gmail.com';
        $mail->Password = 'vfko hohl crbg lgid';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('hardbodyfitnessgym13@gmail.com', 'Hard Body Fitness Gym');
        $mail->addAddress($newEmail);
        $mail->isHTML(true);
        $mail->Subject = "Email Verification OTP";
        $mail->Body = "<p>Hi " . htmlspecialchars($fullName) . ",</p>

                        <p>Your one-time password (OTP) is:</p>

                        <p><strong>$otpCode</strong></p>

                        <p>Please enter this OTP to proceed with email change. If you did not request this, please ignore this message or contact support immediately.</p>

                        <p>Thanks,<br>Hard Body Fitness Gym</p>

                        ";

        $mail->send();
        $_SESSION['show_modal'] = 'otpModal';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } catch (Exception $e) {
        $_SESSION['emailInputError'] = "Failed to send OTP. Try again.";
        $_SESSION['show_modal'] = 'editAccountEmailModal';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

if (isset($_POST['btnAdminConfirmPass'])) {
    $enteredOtp = $_POST['enteredOTP'];
    $sessionOtp = $_SESSION['otp_code'] ?? null;
    $newEmail = $_SESSION['pending_email'] ?? null;
    $userID = $_SESSION['userID'] ?? null;

    if ($enteredOtp == $sessionOtp && $newEmail && $userID) {
        $checkOTPQuery = "UPDATE users SET email = '$newEmail', code = NULL WHERE userID = $userID";
        $checkOTPResult = executeQuery($checkOTPQuery);

        // Clear session data
        unset($_SESSION['otp_code'], $_SESSION['pending_email']);
        $_SESSION['show_modal'] = 'confirmEditEmailInfoModal';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif ($enteredOtp !== $sessionOtp) {
        // OTP is incorrect
        $_SESSION['otpError'] = "The OTP you entered is incorrect. Please try again.";
        $_SESSION['show_modal'] = 'otpModal';
        header("Location: {$_SERVER['PHP_SELF']}");
    }
}
?>