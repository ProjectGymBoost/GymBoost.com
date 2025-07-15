<?php
date_default_timezone_set('Asia/Manila');
if (!empty($_SESSION['userID'])) {
    header("Location: /user/index.php");
    exit();
}

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$loginError = $_SESSION['loginError'] ?? "";

unset($_SESSION['loginError']);

if (isset($_POST['btnLogin'])) {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $checkEmailQuery)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: user/index.php?page=dashboard");
                }
                exit();
            } else {
                $_SESSION['loginError'] = "invalidCredentials";
                header("Location: login.php");
                exit();
            }
        } else {
            mysqli_stmt_close($stmt);
            $_SESSION['loginError'] = "userNotFound";
            header("Location: login.php");
            exit();
        }
    }
}
