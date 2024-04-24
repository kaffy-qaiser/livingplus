<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('917316453337-58kib4llcifroaf5jefe1cdlsqso7kk4.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8080/frontend/login.php');
$client->addScope("email");
$client->addScope("profile");

// Include db.php here to utilize the database connection
include '../backend/db.php';

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if(isset($token['error'])) {
            throw new Exception('Error fetching access token: ' . $token['error_description']);
        }
        $client->setAccessToken($token);

        // Get user profile information from Google
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;

        // Check if the user exists in the database
        $query = "SELECT * FROM login WHERE username = $1";
        $result = pg_query_params($dbHandle, $query, array($email));

        if ($user = pg_fetch_assoc($result)) {
            // User exists, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $email;
            $_SESSION['login_status'] = 'success';

            // Redirect to dashboard.php
            header('Location: ../frontend/dashboard.php');
            exit();
        } else {
            // User doesn't exist, insert new user
            $insertQuery = "INSERT INTO login (username, password) VALUES ($1, 'google_oauth_no_password') RETURNING id";
            $insertResult = pg_query_params($dbHandle, $insertQuery, array($email));
            if ($insertResult) {
                $newUserId = pg_fetch_result($insertResult, 0, 'id');
                $_SESSION['user_id'] = $newUserId;
                $_SESSION['username'] = $email;
                $_SESSION['login_status'] = 'success';

                // Redirect to dashboard.php
                header('Location: ../frontend/dashboard.php');
                exit();
            }
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['login_status'] = 'error';
        header('Location: ../frontend/login.php');
        exit();
    }
}

// Redirect to Google's OAuth 2.0 server
if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . $auth_url);
    exit();
}
?>
