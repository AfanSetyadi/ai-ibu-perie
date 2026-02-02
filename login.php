<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Get error message if any
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);

// Get remembered username from cookie
$rememberedUsername = isset($_COOKIE['remembered_username']) ? $_COOKIE['remembered_username'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IBu PeriE</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <h1 class="logo-title">IBu PeriE</h1>
            <p class="subtitle">Integrated Bundle Of Perinatal CarE</p>
            <p class="hospital-name">PERISTI BAYI RSUD RTN Sidoarjo</p>
        </div>
        
        <div class="login-card">
            <h2>Masuk ke Sistem</h2>
            <form id="loginForm" method="POST" action="login_process.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autocomplete="username" value="<?php echo htmlspecialchars($rememberedUsername); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="rememberMe" name="rememberMe" <?php echo $rememberedUsername ? 'checked' : ''; ?>>
                    <label for="rememberMe">Ingat saya</label>
                </div>
                
                <button type="submit" class="btn-primary">Masuk</button>
                
                <?php if ($errorMessage): ?>
                <div id="errorMessage" class="error-message" style="display: block;">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
                <?php else: ?>
                <div id="errorMessage" class="error-message" style="display: none;"></div>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="login-footer">
            <p>&copy; 2024 RSUD RTN Sidoarjo. All rights reserved.</p>
        </div>
    </div>
    
    <script src="assets/js/login.js"></script>
</body>
</html>

