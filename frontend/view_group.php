<?php
session_start();
require_once '../backend/db.php';  // Ensure the database connection is correctly set up

// Check if the group ID is provided and is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to groups page if no valid ID is provided
    header('Location: groups.php');
    exit();
}

$groupId = intval($_GET['id']);  // Sanitize the input

// Fetch the group details
$query = "SELECT name, description FROM groups WHERE id = $1";
$result = pg_query_params($dbHandle, $query, array($groupId));

if (pg_num_rows($result) > 0) {
    $group = pg_fetch_assoc($result);
} else {
    // If no group found, redirect back with an error message
    $_SESSION['error_message'] = 'Group not found.';
    header('Location: groups.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Group</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <style>
        body, h1, h2, h3, h4, h5, p {
            font-family: 'Catamaran', sans-serif;
            font-style: normal;
        }
        .card {
            border: 1px solid blue;
        }
        .container {
            max-width: 80%; 
            margin: auto;
            padding-top: 30px;
        }
        h1 {
            text-align: left;
            margin-left: 0; 
        }
        .larger-h1 {
            font-size: 2.5em;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1><?= htmlspecialchars($group['name']); ?></h1>
        <p><?= htmlspecialchars($group['description']); ?></p>
        <button onclick="history.back();" class="btn btn-secondary">Back to Groups</button>
    </div>
    <script>
        // Validate the query string to check if 'id' parameter is numeric
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const id = params.get('id');
            if (!id || isNaN(id)) {
                alert('Invalid group ID provided.');
                window.location.href = 'groups.php'; // Redirect if invalid
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
