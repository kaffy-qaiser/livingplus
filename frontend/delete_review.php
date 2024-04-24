<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'navbar.php';
include '../backend/db.php';

// Get review_id from the query string and sanitize it
$review_id = isset($_GET['review_id']) ? intval($_GET['review_id']) : 0;

if ($dbHandle) {
    // Prepare and execute the query to delete the review
    $result = pg_prepare($dbHandle, "delete_review", "DELETE FROM reviews WHERE id = $1");
    $result = pg_execute($dbHandle, "delete_review", array($review_id));

    // Check if the delete was successful
    if ($result && pg_affected_rows($result) > 0) {
        // Redirect back to the reviews list with a success message
        echo "<script>alert('Review deleted successfully.'); window.location = 'reviews.php';</script>";
    } else {
        // Notify user of failure
        echo "<script>alert('Failed to delete the review or review does not exist.'); window.location = 'reviews.php';</script>";
    }
} else {
    // Exit or handle the error as appropriate if database connection fails
    echo "<script>alert('Database connection failed.'); window.location = 'reviews.php';</script>";
    exit;
}
?>

