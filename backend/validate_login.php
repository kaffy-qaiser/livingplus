<?php
// validate_login.php
session_start();
include 'db.php';

// Function to send JSON response
function sendJsonResponse($status, $message, $redirect = '') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'redirect' => $redirect
    ]);
    exit;
}

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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_status'] = 'success';

            // Check if the request expects a JSON response
            if (!empty($_POST['expectJson'])) {
                sendJsonResponse('success', 'Login successful.', '../frontend/dashboard.php');
            } else {
                header('Location: ../frontend/dashboard.php');
                exit; // Always call exit after headers to ensure the script terminates
            }
        } else {
            $_SESSION['login_status'] = 'failed';
            // Check if the request expects a JSON response
            if (!empty($_POST['expectJson'])) {
                sendJsonResponse('failed', 'Invalid username or password.');
            } else {
                header('Location: ../frontend/login.php');  // Redirect back to the login page
                exit;
            }
        }
    } else {
        $_SESSION['login_status'] = 'error';
        // Check if the request expects a JSON response
        if (!empty($_POST['expectJson'])) {
            sendJsonResponse('error', 'An error occurred. Please try again.');
        } else {
            header('Location: ../frontend/login.php'); // Redirect back to the login page
            exit;
        }
    }
} else {
    // Redirect back to the login page if the form data is not set
    header('Location: ../frontend/login.php');
    exit;
}
?>