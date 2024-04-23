<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('917316453337-58kib4llcifroaf5jefe1cdlsqso7kk4.apps.googleusercontent.com');
$client->setClientSecret('YOUR_NEW_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/frontend/login.php'); // Adjust if necessary
$client->addScope("email");
$client->addScope("profile");

// Include db.php here to utilize the database connection
include '../backend/db.php'; // Adjust the path as necessary to point to your db.php file

if (isset($_GET['code'])) {
    echo '<pre>';

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile information from Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Check if the user exists in the database
    $query = "SELECT * FROM login WHERE username = $1";
    $result = pg_query_params($dbHandle, $query, array($email));

    if ($user = pg_fetch_assoc($result)) {
        // User exists, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    } else {
        // User doesn't exist, insert new user
        $insertQuery = "INSERT INTO login (username, password) VALUES ($1, $2) RETURNING id";
        $insertResult = pg_query_params($dbHandle, $insertQuery, array($email, 'google_oauth_no_password'));
        if ($insertResult) {
            $newUserId = pg_fetch_result($insertResult, 0, 'id');
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $email; // Storing email as username
        }
    }

    $_SESSION['login_status'] = 'success';
    header('Location: ../frontend/dashboard.php');
    exit();
}

// Redirect to Google's OAuth 2.0 server
if (!isset($_GET['code'])) {
    // echo "not set";
    $auth_url = $client->createAuthUrl();
    header('Location: ' . $auth_url);
    exit();
}
?>
