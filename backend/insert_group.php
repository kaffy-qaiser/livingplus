<?php
session_start();
require_once 'db.php'; // Ensure this path is correct

// Check if the form data is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupName']) && isset($_POST['groupDescription'])) {
    $groupName = $_POST['groupName'];
    $groupDescription = $_POST['groupDescription'];

    // Prepare a query for inserting data into the database
    $query = "INSERT INTO groups (name, description) VALUES ($1, $2) RETURNING id";

    // Use prepared statements to prevent SQL Injection
    $result = pg_query_params($dbHandle, $query, array($groupName, $groupDescription));

    if ($result) {
        $groupId = pg_fetch_result($result, 0, 'id');

        // Optionally add the creator as a member of the group automatically
        $insertMembership = "INSERT INTO group_memberships (group_id, user_id) VALUES ($1, $2)";
        pg_query_params($dbHandle, $insertMembership, array($groupId, $_SESSION['user_id']));

        // Redirect back to the groups page with a success message
        $_SESSION['flash'] = 'Group created successfully!';
        header('Location: ../frontend/groups.php');
        exit();
    } else {
        // Handle errors such as a duplicate group name
        $_SESSION['flash'] = 'Error creating group. The group name might already exist.';
        header('Location: ../frontend/create_groups.php');
        exit();
    }
} else {
    // Redirect to the form page if the method is not POST or data is missing
    header('Location: ../frontend/create_groups.php');
    exit();
}
?>
