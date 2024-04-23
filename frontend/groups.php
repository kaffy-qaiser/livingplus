<?php
session_start();
require_once '../backend/db.php';  // Ensure the database connection is correctly set up

// Check if user is logged in and get the user ID
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Query to fetch groups the user is a member of
$query = "
    SELECT g.id, g.name, g.description
    FROM groups g
    JOIN group_memberships gm ON g.id = gm.group_id
    WHERE gm.user_id = $1;
";

$result = pg_query_params($dbHandle, $query, array($userId));
$groupsAvailable = pg_num_rows($result) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Groups</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <style>
        body, h1, h2, h3, h4, h5, p {
            font-family: 'Catamaran', sans-serif;
            font-style: normal;
        }
        .card {
            border: 1px solid blue;
            transition: border-color 0.3s ease, background-color 0.3s ease;
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
        .selected {
            border-color: #4CAF50; /* Green border for selected cards */
            background-color: #f0f0f0; /* Light grey background for selected cards */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>My Groups</h1>
        <?php if ($groupsAvailable): ?>
            <div class="group-list">
                <?php while ($group = pg_fetch_assoc($result)): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($group['name']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($group['description']); ?></p>
                            <a href="view_group.php?id=<?= htmlspecialchars($group['id']); ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No groups available. Join or create a new group.</p>
        <?php endif; ?>
        <div class="button-group">
            <button onclick="window.location.href='create_group.php';" class="btn btn-success">Create Group</button>
            <button onclick="window.location.href='join_group.php';" class="btn btn-secondary">Join Group</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    // Toggle a class to change appearance
                    this.classList.toggle('selected');
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.card').click(function() {
                $(this).toggleClass('selected');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
