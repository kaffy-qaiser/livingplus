<?php
include 'db.php'; // Adjust the path to your db.php file if necessary

// Start the session at the top of the file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input
    $listingName = htmlspecialchars($_POST['listingName']);
    $reviewDate = $_POST['reviewDate']; // Assuming this is correctly formatted for your DB
    $amenities = (int)$_POST['amenities'];
    $affordability = (int)$_POST['affordability'];
    $location = (int)$_POST['location'];
    $quality = (int)$_POST['quality'];
    $review = htmlspecialchars($_POST['review']);
    $reviewTitle = htmlspecialchars($_POST['reviewTitle']);

    // Check if user_id is set in session
    if (!isset($_SESSION['user_id'])) {
        echo "User is not logged in.";
        // Optionally, redirect or handle the error
        exit;
    }
    $userId = $_SESSION['user_id']; // Retrieve user_id from session


    // Find the listing ID based on the listing name
    $stmt = $conn->prepare("SELECT id FROM listings WHERE name = ?");
    $stmt->execute([$listingName]);
    $listing = $stmt->fetch();

    // Insert review into the database if listing was found
    if ($listing) {
        // Include user_id in the INSERT statement
        $stmt = $conn->prepare("INSERT INTO reviews (listing_id, review_date, amenities, affordability, location, quality, review, review_title, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$listing['id'], $reviewDate, $amenities, $affordability, $location, $quality, $review, $reviewTitle, $userId]);
        
        // Redirect back to reviews.php or to another page as needed
        header("Location: ../frontend/reviews.php");
        exit();
    } else {
        echo "Listing not found.";
        // Optionally, redirect or handle the error
    }
} 
else {
    // Redirect or handle invalid request method
    header("Location: ../frontend/add_review.php");
    exit();
}
?>
