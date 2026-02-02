<?php
session_start();

// Clear all session data
session_unset();
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['remembered_username'])) {
    setcookie('remembered_username', '', time() - 3600, '/');
}

// Redirect to login
header('Location: login.php');
exit();
?>

