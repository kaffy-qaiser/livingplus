<?php
session_start();
include 'db.php';  // Assuming this points to the PostgreSQL connection setup

// Check if the form data exists
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the database query securely
    $query = "SELECT * FROM login WHERE username = $1";
    $result = pg_query_params($dbHandle, $query, array($username));

    if ($result) {
        $user = pg_fetch_assoc($result);

        // Assuming password is stored in plain text for comparison (Consider using password hashing for security)
        if ($user && $user['password'] === $password) {
            $_SESSION['user_id'] = $user['id'];  // Or whatever you want to store in the session
            $_SESSION['username'] = $user['username']; // Store the username in the session
            $_SESSION['login_status'] = 'success';
            header('Location: ../frontend/dashboard.php');     // Redirect to the dashboard page
            exit; // Always call exit after headers to ensure the script terminates
        } else {
            $_SESSION['login_status'] = 'failed';
            header('Location: ../frontend/login.php');  // Redirect back to the login page
            exit; // Always call exit after headers to ensure the script terminates
        }
    } else {
        // Query failed to execute or returned no result
        $_SESSION['login_status'] = 'error'; // Consider a more descriptive error handling or logging
        header('Location: ../frontend/login.php'); // Redirect back to the login page
        exit; // Always call exit after headers to ensure the script terminates
    }
} else {
    // Redirect back to the login page if the form data is not set
    header('Location: ../frontend/login.php');
    exit; // Always call exit after headers to ensure the script terminates
}
?>
