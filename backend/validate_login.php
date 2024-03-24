<?php
session_start();
include 'db.php';  // Make sure this points to your database connection script

// Check if the form data exists
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the database query
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) {  // Direct comparison instead of password_verify
        $_SESSION['user_id'] = $user['id'];  // Or whatever you want to store in the session
        // Instead of redirecting, set a session variable to indicate success
        $_SESSION['username'] = $user['username']; // Store the username in the session
        $_SESSION['login_status'] = 'success';
        header('Location: /frontend/dashboard.php');     // Redirect to the dashboard page
    } else {
        // Instead of displaying a message, set a session variable to indicate failure
        $_SESSION['login_status'] = 'failed';
        header('Location: /frontend/login.php');  // Redirect back to the login page
    }
} else {
    // Redirect back to the login page if the form data is not set
    header('Location: /frontend/login.php');
}
?>
