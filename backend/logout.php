<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Unset all of the session variables.
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    // Redirect to login page
    header("Location: ../frontend/login.php");
    exit();
?>
