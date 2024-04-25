<?php
// Include db.php at the start to ensure PHP code is executed before sending HTML content.
include_once '../backend/db.php';

// Start the session at the top of the file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Insert the new user into the users table
    $sql = "INSERT INTO login (username, password) VALUES ($1, $2)";
    $result = pg_query_params($dbHandle, $sql, array($username, $password));
    
    if ($result) {
        $_SESSION['username'] = $username;
        $_SESSION['login_status'] = 'success';
        // Registration successful, redirect to dashboard.php
        header("Location: dashboard.php");
        exit();
    } else {
        // Registration failed, display an error message
        $errorMessage = "Registration failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
<div class="login-container">
    <form class="login-form" id="registrationForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
        </div>
        <div class="button-group">
            <button type="submit">Register</button>
        </div>
        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>
    </form>
</div>
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
