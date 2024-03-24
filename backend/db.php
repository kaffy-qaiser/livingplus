<?php
$host = 'localhost';
$dbname = 'logindb';
$user = 'postgres';  // Replace with your database username
$pass = 'password';  // Replace with your database password
$dsn = "pgsql:host=$host;dbname=$dbname";
try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
