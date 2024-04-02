<?php
// Include db.php at the start to ensure PHP code is executed before sending HTML content.
include_once '../backend/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
<div class="login-container">
    <form class="login-form" action="../backend/validate_login.php" method="post">
        <div class="logo-container">
            <img src="images/newlogo.png" alt="Logo" class="center-logo">
        </div>
        <div class="form-group floating-label">
            <input id="username" type="text" name="username" required>
            <label for="username">Username</label>
        </div>
        <div class="form-group floating-label">
            <input id="password" type="password" name="password" required>
            <label for="password">Password</label>
            <a href="/reset-password" class="forgot-password">Forgot Password?</a>
        </div>
        <div class="button-group">
            <button type="submit">Login</button>
            <img src="images/auth_or.png" alt="google_auth" class="authImage">
            <button type="button" class="google-login">
                <img src="images/google_logo.png" alt="Google" class="google-logo">Sign in with Google
            </button>
        </div>
    </form>
</div>
<!--  The navbar was taken from this youtube video: https://www.youtube.com/watch?v=wEfaoAa99XY-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inputs = document.querySelectorAll('.floating-label input[type="text"], .floating-label input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener("focusout", function(e) {
                if (e.target.value.length > 0) e.target.classList.add('not-empty');
                else e.target.classList.remove('not-empty');
            });
            if (input.value.length > 0) input.classList.add('not-empty');
        });
    });


</script>
</body>
</html>



