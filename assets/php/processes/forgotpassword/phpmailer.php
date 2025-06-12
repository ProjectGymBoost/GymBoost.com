<?php
session_start();
include("../../../shared/connect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../../shared/phpmailer/src/Exception.php');
include('../../../shared/phpmailer/src/PHPMailer.php');
include('../../../shared/phpmailer/src/SMTP.php');

$errors = array();

// Step 1: User submits email for password reset
if (isset($_POST['btnContinue'])) {
    $email = $_POST['email'];
    $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
    $checkEmailResult = executeQuery($checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $code = rand(111111, 999999);
        $insertCodeQuery = "UPDATE users SET code = $code WHERE email = '$email'";
        $insertCodeResult = executeQuery($insertCodeQuery);

        if ($insertCodeResult) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is <strong>$code</strong>.";

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
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
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
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

// Step 3: User submits new password
if (isset($_POST['btnChangePassword'])) {
    $_SESSION['info'] = "";
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $_SESSION['info'] = "";
        $errors['password'] = "Confirm password not matched!";
    } else {
        $email = $_SESSION['email'];
        $code = 0;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET code = ?, password = ? WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("iss", $code, $hashedPassword, $email);
            if ($stmt->execute()) {
                $_SESSION['info'] = "Your password has been changed. You can now log in with your new password.";
                header('Location: password-changed.php');
                exit();
            } else {
                $errors['db-error'] = "Failed to change your password!";
            }
            $stmt->close();
        } else {
            $errors['db-error'] = "Something went wrong with the statement.";
        }
    }
}

?>