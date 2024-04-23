<?php
session_start();
require_once '../backend/db.php';  // Ensure the database connection is correctly set up

$message = '';  // For displaying messages to the user
if (isset($_POST['join'])) {
    $groupId = $_POST['groupId'];
    $userId = $_SESSION['user_id']; // Assume user's ID is stored in session

    // Check if the user is already a member of the group
    $checkQuery = "SELECT * FROM group_memberships WHERE group_id = $1 AND user_id = $2";
    $checkResult = pg_query_params($dbHandle, $checkQuery, array($groupId, $userId));

    if (pg_num_rows($checkResult) > 0) {
        $message = 'Already joined the group.';
    } else {
        // SQL to insert the user into the selected group
        $insertQuery = "INSERT INTO group_memberships (group_id, user_id) VALUES ($1, $2)";
        if (pg_query_params($dbHandle, $insertQuery, array($groupId, $userId))) {
            $message = 'Successfully joined the group!';
        } else {
            $message = 'Failed to join the group.';
        }
    }
    // Sending response back to AJAX call
    echo json_encode(array("message" => $message));
    exit;
}

// Fetching all groups
$query = "SELECT id, name, description FROM groups";
$result = pg_query($dbHandle, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <title>Join a Group</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2>Join a Group</h2>
        <div id="messageArea" class="alert alert-info" style="display: none;"></div>
        <div class="list-group">
            <?php while ($group = pg_fetch_assoc($result)): ?>
                <div class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><?= htmlspecialchars($group['name']) ?></h5>
                    <p class="list-group-item-text"><?= htmlspecialchars($group['description']) ?></p>
                    <button onclick="joinGroup('<?= htmlspecialchars($group['id']) ?>');" class="btn btn-primary">Join Group</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function joinGroup(groupId) {
            fetch('join_group.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'join=true&groupId=' + groupId
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('messageArea').style.display = 'block';
                document.getElementById('messageArea').textContent = data.message;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
