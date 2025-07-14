<?php
session_start();
include("../../../shared/connect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../../shared/phpmailer/src/Exception.php');
include('../../../shared/phpmailer/src/PHPMailer.php');
include('../../../shared/phpmailer/src/SMTP.php');

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
        } else {
            echo "Error: Email session variable is missing.";
            exit();
        }
    } else {
        echo "Error: Passwords do not match.";
        exit();
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

}


?>