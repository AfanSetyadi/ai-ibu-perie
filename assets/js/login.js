// Login functionality - Client-side validation only
// Form submission is handled by PHP (login_process.php)
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');
    
    // Client-side validation before form submission
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            // Clear previous error
            if (errorMessage) {
                errorMessage.style.display = 'none';
                errorMessage.textContent = '';
            }
            
            // Basic validation
            if (!username || !password) {
                e.preventDefault();
                showError('Username dan password harus diisi');
                return false;
            }
            
            // Form will submit to login_process.php
            return true;
        });
    }
    
    function showError(message) {
        if (errorMessage) {
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
        }
    }
});

