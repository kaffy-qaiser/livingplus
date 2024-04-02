<?php
include 'db.php'; // Make sure you have included the database connection

// Check if we have a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get review_id from the POST data and sanitize it
    $review_id = isset($_POST['reviewId']) ? intval($_POST['reviewId']) : 0;
    $review_title = isset($_POST['reviewTitle']) ? $_POST['reviewTitle'] : '';
    $review_text = isset($_POST['reviewText']) ? $_POST['reviewText'] : ''; 
    $review_date = isset($_POST['reviewDate']) ? $_POST['reviewDate'] : '';
    $amenities = isset($_POST['amenities']) ? intval($_POST['amenities']) : 0;
    $affordability = isset($_POST['affordability']) ? intval($_POST['affordability']) : 0;
    $location = isset($_POST['location']) ? intval($_POST['location']) : 0;
    $quality = isset($_POST['quality']) ? intval($_POST['quality']) : 0;

    // Fetch the current review data
    $result = pg_query_params($dbHandle, "SELECT * FROM reviews WHERE id = $1", array($review_id));
    if ($result && pg_num_rows($result) > 0) {
        $currentReview = pg_fetch_assoc($result);

        // Prepare updates
        $updates = [];
        $params = [];
        $query_parts = [];
        $counter = 1;

        if ($currentReview['review_title'] !== $review_title) {
            $updates[] = "review_title = $".$counter++;
            $params[] = $review_title;
        }
        if ($currentReview['review'] !== $review_text) {
            $updates[] = "review = $".$counter++;
            $params[] = $review_text;
        }
        if ($currentReview['review_date'] !== $review_date) {
            $updates[] = "review_date = $".$counter++;
            $params[] = $review_date;
        }
        if ($currentReview['quality'] !== $quality) {
            $updates[] = "quality = $".$counter++;
            $params[] = $quality;
        }
        if ($currentReview['location'] !== $location) {
            $updates[] = "location = $".$counter++;
            $params[] = $location;
        }
        if ($currentReview['amenities'] !== $amenities) {
            $updates[] = "amenities = $".$counter++;
            $params[] = $amenities;
        }
        if ($currentReview['affordability'] !== $affordability) {
            $updates[] = "affordability = $".$counter++;
            $params[] = $affordability;
        }

        // If there are updates, proceed to update the database
        if (count($updates) > 0) {
            $params[] = $review_id; // Add review_id as the last parameter
            $sqlUpdate = "UPDATE reviews SET " . implode(', ', $updates) . " WHERE id = $".$counter;
            $resultUpdate = pg_query_params($dbHandle, $sqlUpdate, $params);

            // Redirect or inform the user of success
            echo "<script>alert('Review updated successfully.'); window.location = '../frontend/items.php';</script>";
        } else {
            // Inform the user that no changes were made
            echo "<script>alert('No changes detected.'); window.location = '../frontend/items.php';</script>";
        }
    } else {
        // Inform the user that the review was not found
        echo "<script>alert('Review not found.'); window.location = '../frontend/items.php';</script>";
    }
} else {
    // Handle non-POST requests
    echo "<script>alert('Invalid request method.'); window.location = '../frontend/items.php';</script>";
}
?>
