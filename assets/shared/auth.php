<?php 
if (empty($_SESSION['userID'])) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['role'] === 'user') {
    header("Location: ../user/index.php");
    exit();
}
if (!empty($_SESSION['userID'])) {
    $_SESSION['lastVisited'] = $_SERVER['REQUEST_URI'];
}
?>