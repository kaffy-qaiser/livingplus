<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Start the session at the top of the file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitizing inputs
    $listingName = htmlspecialchars($_POST['listingName']);
    $reviewDate = $_POST['reviewDate'];
    $amenities = (int)$_POST['amenities'];
    $affordability = (int)$_POST['affordability'];
    $location = (int)$_POST['location'];
    $quality = (int)$_POST['quality'];
    $review = htmlspecialchars($_POST['review']);
    $reviewTitle = htmlspecialchars($_POST['reviewTitle']);

    // Check if user_id is set in session
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('You must be logged in to submit a review.'); window.location = '../frontend/login.php';</script>";
        exit;
    }
    $userId = $_SESSION['user_id'];

    // Find the listing ID based on the listing name
    $result = pg_query_params($dbHandle, "SELECT id FROM listings WHERE name = $1", array($listingName));
    if ($result && pg_num_rows($result) > 0) {
        $listing = pg_fetch_assoc($result);

        // Insert review into the database
        $insertQuery = "INSERT INTO reviews (listing_id, review_date, amenities, affordability, location, quality, review, review_title, user_id) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
        $insertResult = pg_query_params($dbHandle, $insertQuery, array($listing['id'], $reviewDate, $amenities, $affordability, $location, $quality, $review, $reviewTitle, $userId));
        
        if ($insertResult) {
            // Review inserted successfully
            echo "<script>alert('Review submitted successfully.'); window.location = '../frontend/reviews.php';</script>";
            exit;
        } else {
            // Failed to insert review
            echo "<script>alert('Failed to submit review. Please try again later.'); window.location = '../frontend/add_review.php?name=" . urlencode($listingName) . "';</script>";
            exit;
        }
    } else {
        // Listing not found
        echo "<script>alert('Listing not found. Please try again.'); window.location = '../frontend/add_review.php';</script>";
        exit;
    }
} else {
    // Invalid request method
    header("Location: ../frontend/add_review.php");
    exit;
}
?>
