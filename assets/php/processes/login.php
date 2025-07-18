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

                // If the user is inactive, show error message
                if ($user['state'] === 'Inactive') {
                    $_SESSION['loginError'] = 'accountInactive'; 
                    header("Location: login.php"); 
                    exit();
                }


                // Set session variables for active users
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['state'] = $user['state'];

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: user/index.php?page=dashboard");
                }
                exit();

            } else {
                // Incorrect password
                $_SESSION['loginError'] = "invalidCredentials";
                header("Location: login.php");
                exit();
            }
        } else {
            // No user found
            $_SESSION['loginError'] = "userNotFound";
            header("Location: login.php");
            exit();
        }
    }
}


