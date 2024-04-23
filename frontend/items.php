<?php
// Start the session at the top of the file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'navbar.php';
include '../backend/db.php'; // Adjust this path as necessary. Ensure db.php uses pg_connect for PostgreSQL.

// Initialize reviews array
$reviews = [];

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Connect to the database
    // Assuming $dbHandle is the variable holding the connection from db.php
    if ($dbHandle) {
        // Prepare and execute the query to get reviews and listing names for the logged-in user
        $result = pg_prepare($dbHandle, "fetch_reviews", 
            "SELECT reviews.*, listings.name AS listing_name 
            FROM reviews 
            JOIN listings ON reviews.listing_id = listings.id 
            WHERE reviews.user_id = $1");
        $result = pg_execute($dbHandle, "fetch_reviews", array($user_id));
        
        // Fetch the reviews and listing names
        if ($result) {
            $reviews = pg_fetch_all($result);
        }
    } else {
        echo "Failed to connect to the database.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <title>Living+</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="styles/myreviews.css">
</head>
<body>
<main class="container">
    <?php
    if (!empty($reviews)) {
        foreach ($reviews as $review) {
            echo '<div class="review-card">';
            echo '<div class="review-content">';
            echo '<h5 class="review-title">' . htmlspecialchars($review['listing_name']) . '</h5>';
            echo '<h6 class="review-date">Date: ' . htmlspecialchars($review['review_date']) . '</h6>';
            echo '<p class="review-text">' . htmlspecialchars($review['review']) . '</p>';
            echo '<p class="review-details">Amenities: ' . htmlspecialchars($review['amenities']) . '</p>';
            echo '<p class="review-details">Affordability: ' . htmlspecialchars($review['affordability']) . '</p>';
            echo '<p class="review-details">Location: ' . htmlspecialchars($review['location']) . '</p>';
            echo '<p class="review-details">Quality: ' . htmlspecialchars($review['quality']) . '</p>';
            echo '<div class="review-actions">';
            echo '<button id="edit-btn" onclick="location.href=\'edit_review.php?review_id=' . urlencode($review['id']) . '&listing_id=' . urlencode($review['listing_id']) . '\'" class="edit-link">Edit Review</button>';
            echo '<button id="delete-btn" onclick="location.href=\'delete_review.php?review_id=' . urlencode($review['id']) . '&listing_id=' . urlencode($review['listing_id']) . '" class="delete-link">Delete Review</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="no-reviews">No reviews found</p>';
    }
    ?>

</main>
</body>
</html>
