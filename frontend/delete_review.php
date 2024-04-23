<?php
session_start();
include '../backend/db.php'; // Adjust this path as necessary. Ensure db.php uses pg_connect for PostgreSQL.

// Check if the review_id and listing_id are set in the GET parameters
if (isset($_GET['review_id']) && isset($_GET['listing_id'])) {
    $review_id = $_GET['review_id'];
    $listing_id = $_GET['listing_id'];

    // Connect to the database
    // Assuming $dbHandle is the variable holding the connection from db.php
    if ($dbHandle) {
        // Prepare and execute the query to delete the review
        $result = pg_prepare($dbHandle, "delete_review", "DELETE FROM reviews WHERE id = $1 AND listing_id = $2");
        $result = pg_execute($dbHandle, "delete_review", array($review_id, $listing_id));

        if ($result) {
            // Redirect to the items page after successful deletion
            header('Location: items.php');
            exit;
        } else {
            echo "Failed to delete the review.";
            exit;
        }
    } else {
        echo "Failed to connect to the database.";
        exit;
    }
} else {
    // Redirect back to the items page if the GET parameters are not set
    header('Location: items.php');
    exit;
}
?>