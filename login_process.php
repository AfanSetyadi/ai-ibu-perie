<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $rememberMe = isset($_POST['rememberMe']) ? true : false;
    
    // Basic validation
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'Username dan password harus diisi';
        header('Location: login.php');
        exit();
    }
    
    // Authentication logic
    // For demo: accept any credentials
    // In production, validate against database
    // Example: username = "admin", password = "admin123"
    
    // For demo purposes, accept any credentials
    // In production, uncomment below and implement proper authentication:
    /*
    if ($username === 'admin' && $password === 'admin123') {
        // Valid credentials
    } else {
        $_SESSION['error_message'] = 'Username atau password salah';
        header('Location: login.php');
        exit();
    }
    */
    
    // Set session
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['username'] = $username;
    
    // Set cookie if remember me is checked
    if ($rememberMe) {
        setcookie('remembered_username', $username, time() + (86400 * 30), '/'); // 30 days
    } else {
        // Clear cookie if not checked
        if (isset($_COOKIE['remembered_username'])) {
            setcookie('remembered_username', '', time() - 3600, '/');
        }
    }
    
    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}
?>

