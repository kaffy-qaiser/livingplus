<?php
require_once '../vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('917316453337-58kib4llcifroaf5jefe1cdlsqso7kk4.apps.googleusercontent.com');
$client->setClientSecret('YOUR_NEW_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/frontend/login.php'); // Adjust if necessary
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile information
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Process user info (e.g., check if user exists in your database)
    // Redirect to another page or session initiation
    header('Location: your_redirect_page.php'); // Specify your redirect page
    exit();
}

// Redirect to Google's OAuth 2.0 server
if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . $auth_url);
    exit();
}
?>
