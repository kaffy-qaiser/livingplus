<?php
include 'db.php'; // Adjust the path to your db.php file if necessary

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

    // Find the listing ID based on the listing name
    $stmt = $conn->prepare("SELECT id FROM listings WHERE name = ?");
    $stmt->execute([$listingName]);
    $listing = $stmt->fetch();

    // Insert review into the database if listing was found
    if ($listing) {
        $stmt = $conn->prepare("INSERT INTO reviews (listing_id, review_date, amenities, affordability, location, quality, review, review_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$listing['id'], $reviewDate, $amenities, $affordability, $location, $quality, $review, $reviewTitle]);
        
        // Redirect back to reviews.php or to another page as needed
        header("Location: ../frontend/reviews.php");
        exit();
    } else {
        echo "Listing not found.";
        // Optionally, redirect or handle the error
    }
} else {
    // Redirect or handle invalid request method
    header("Location: ../frontend/add_review.php");
    exit();
}
?>
