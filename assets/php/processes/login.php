<?php
date_default_timezone_set('Asia/Manila');
if (!empty($_SESSION['userID'])) {
    header("Location: /user/index.php");
    exit();
}
//Sanitize user inputs
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$loginError = $_SESSION['loginError'] ?? "";
$unlockTime = $_SESSION['unlockTime'] ?? null;

unset($_SESSION['loginError']);
unset($_SESSION['unlockTime']);


if (isset($_POST['btnLogin'])) {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    //Check the user's email
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $checkEmailQuery)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        // Login Attempts
        if ($user = mysqli_fetch_assoc($result)) {
            if ($user['loginAttempts'] >= 3) {
                $lastAttempt = strtotime($user['lastAttempt']);
                $currentTime = time();
                $lockoutDuration = 3 * 60;

                if ($currentTime - $lastAttempt < $lockoutDuration) {
                    $_SESSION['loginError'] = "tooManyAttempts";
                    $_SESSION['unlockTime'] = $lastAttempt + $lockoutDuration;

                    header("Location: login.php");
                    exit();
                } else {
                    // Reset attempts
                    $resetQuery = "UPDATE users SET loginAttempts = 0, lastAttempt = NULL WHERE email = ?";
                    $resetStmt = mysqli_prepare($conn, $resetQuery);
                    mysqli_stmt_bind_param($resetStmt, "s", $email);
                    mysqli_stmt_execute($resetStmt);
                }
            }

            // Login user, update login attempts
            if ($loginError !== "tooManyAttempts") {
                if (password_verify($password, $user['password'])) {
                    $resetQuery = "UPDATE users SET loginAttempts = 0 WHERE email = ?";
                    $resetStmt = mysqli_prepare($conn, $resetQuery);
                    mysqli_stmt_bind_param($resetStmt, "s", $email);
                    mysqli_stmt_execute($resetStmt);

                    $_SESSION['userID'] = $user['userID'];
                    $_SESSION['firstName'] = $user['firstName'];
                    $_SESSION['lastName'] = $user['lastName'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header("Location: admin/index.php?login=success");
                    } else {
                        header("Location: user/index.php?page=dashboard&login=success");
                    }
                    exit();
                } else {
                    $updateQuery = "UPDATE users SET loginAttempts = loginAttempts + 1, lastAttempt = NOW() WHERE email = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "s", $email);
                    mysqli_stmt_execute($updateStmt);

                    $_SESSION['loginError'] = "invalidCredentials";
                    header("Location: login.php");
                    exit();

                }
            }
        } else {
            $loginError = "userNotFound";
        }

        mysqli_stmt_close($stmt);
    }
}
?>