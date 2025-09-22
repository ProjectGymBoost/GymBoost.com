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

// Query to get user info from db
$userInfoArray = array();
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $userInfoQuery = "
    SELECT 
      u.*, 
      m.planType, 
      um.startDate, 
      um.endDate
  FROM users u
  LEFT JOIN user_memberships um ON u.userID = um.userID
  LEFT JOIN memberships m ON um.membershipID = m.membershipID
  WHERE u.state = 'Active' 
    AND u.userID = $userID;
    ";
}


$userInfoResult = executeQuery($userInfoQuery);
if (mysqli_num_rows($userInfoResult) > 0) {
    $userInfoArray = mysqli_fetch_assoc($userInfoResult);


    $pfpFileName = $userInfoArray['profilePicture'] ?? 'defaultProfile.png';

    if (!empty($userInfoArray['birthday'])) {
        $birthDate = new DateTime($userInfoArray['birthday']);
        $today = new DateTime();
        $userInfoArray['age'] = $birthDate->diff($today)->y;
    } else {
        $userInfoArray['age'] = 'N/A';
    }
}

if (isset($_POST['btnSaveProfile'])) {
    $uploadError = false;

    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] !== UPLOAD_ERR_NO_FILE) {
        $fileError = $_FILES['profilePic']['error'];

        if ($fileError === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profilePic']['tmp_name'];
            $fileName = $_FILES['profilePic']['name'];
            $fileSize = $_FILES['profilePic']['size'];
            $fileType = $_FILES['profilePic']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['uploadStatus'] = 'invalid_type';
                $uploadError = true;
            } elseif ($fileSize > $maxFileSize) {
                $_SESSION['uploadStatus'] = 'file_too_large';
                $uploadError = true;
            } else {
                $uploadDir = __DIR__ . '/../../../img/profile/';
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = uniqid('profile_', true) . '.' . $extension;
                $destinationPath = $uploadDir . $newFileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                    $currentPic = $userInfoArray['profilePicture'];
                    if ($currentPic && $currentPic !== 'defaultProfile.png') {
                        $oldFilePath = $uploadDir . $currentPic;
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    executeQuery("
                        UPDATE users 
                        SET profilePicture = '$newFileName' 
                        WHERE userID = $userID
                    ");
                    $_SESSION['uploadStatus'] = 'success';
                } else {
                    $_SESSION['uploadStatus'] = 'upload_failed';
                    $uploadError = true;
                }
            }
        } else {
            $_SESSION['uploadStatus'] = 'upload_failed';
            $uploadError = true;
        }
    }

    if (!$uploadError) {
        $_SESSION['profilePicUpdated'] = true;
        header("Location: {$_SERVER['PHP_SELF']}?page=profile");
        exit;
    }
}


if (isset($_POST['btnRemovePic'])) {
    $uploadDir = __DIR__ . '/../../../img/profile/';
    $currentPic = $userInfoArray['profilePicture'];

    if ($currentPic && $currentPic !== 'defaultProfile.png') {
        $oldFilePath = $uploadDir . $currentPic;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
    }
    $removePicQuery = "UPDATE users SET profilePicture = 'defaultProfile.png' WHERE userID = $userID";
    executeQuery($removePicQuery);

    $_SESSION['profilePicRemoved'] = true;
    header("Location: {$_SERVER['PHP_SELF']}?page=profile");
    exit;
}

if (isset($_POST['btnSaveInfo'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userID = $_SESSION['userID'];

    $updateInfoQuery = "UPDATE users SET firstName = '$firstName',
    lastName = '$lastName'
    WHERE userID = $userID";

    executeQuery($updateInfoQuery);
    $_SESSION['profileUpdated'] = true;
    header("Location: {$_SERVER['PHP_SELF']}?page=profile");
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
            header("Location: {$_SERVER['PHP_SELF']}?page=profile");
            exit;
        }

        $getPasswordQuery = "SELECT password FROM users WHERE userID = $userID";
        $getPasswordResult = executeQuery($getPasswordQuery);
        $user = mysqli_fetch_assoc($getPasswordResult);

        if (!$user || !password_verify($currentPass, $user['password'])) {
            $_SESSION['currentPasswordError'] = "Current password is incorrect.";
            header("Location: {$_SERVER['PHP_SELF']}?page=profile");
            exit;
        }
        if (password_verify($newPass, $user['password'])) {
            $_SESSION['currentPasswordError'] = "New password cannot be the same as your current password.";
            header("Location: {$_SERVER['PHP_SELF']}?page=profile");
            exit;
        }

        if ($isChangingPassword) {
            if ($newPass !== $confirmPass) {
                $_SESSION['currentPasswordError'] = "New password and confirm password do not match.";
                header("Location: {$_SERVER['PHP_SELF']}?page=profile");
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
            header("Location: {$_SERVER['PHP_SELF']}?page=profile");
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
            header("Location: {$_SERVER['PHP_SELF']}?page=profile");
            exit;
        }
    }
    header("Location: {$_SERVER['PHP_SELF']}?page=profile");
    exit;
}

if (isset($_POST['btnCloseDelete'])) {
    $uploadDir = __DIR__ . '/../../../img/profile/';
    $currentPic = $userInfoArray['profilePicture'];

    if ($currentPic && $currentPic !== 'defaultProfile.png') {
        $picPath = $uploadDir . $currentPic;
        if (file_exists($picPath)) {
            unlink($picPath);
        }
    }

    $deleteAccQuery = "DELETE FROM users WHERE userID = $userID";
    executeQuery($deleteAccQuery);
    session_unset();
    session_destroy();

    header("Location: ../login.php");
    exit;
}

