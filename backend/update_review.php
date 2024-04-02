<?php
include 'db.php'; // Make sure you have included the database connection

// Check if we have a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get review_id from the POST data and sanitize it
    $review_id = isset($_POST['reviewId']) ? intval($_POST['reviewId']) : 0;
    $review_title = isset($_POST['reviewTitle']) ? $_POST['reviewTitle'] : '';
    $review_text = isset($_POST['reviewText']) ? $_POST['reviewText'] : ''; // Make sure this matches with the form's textarea name attribute
    $review_date = isset($_POST['reviewDate']) ? $_POST['reviewDate'] : '';
    $amenities = isset($_POST['amenities']) ? intval($_POST['amenities']) : 0;
    $affordability = isset($_POST['affordability']) ? intval($_POST['affordability']) : 0;
    $location = isset($_POST['location']) ? intval($_POST['location']) : 0;
    $quality = isset($_POST['quality']) ? intval($_POST['quality']) : 0;
    

    // Fetch the current review data
    $stmt = $conn->prepare("SELECT * FROM reviews WHERE review_id = :review_id");
    $stmt->execute(['review_id' => $review_id]);
    $currentReview = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the review exists
    if ($currentReview) {
        // Compare each field to see if there has been a change
        $updates = [];
        $params = [];
        if ($currentReview['review_title'] !== $review_title) {
            $updates[] = "review_title = :review_title";
            $params['review_title'] = $review_title;
        }
        if ($currentReview['review'] !== $review_text) {
            $updates[] = "review = :review_text"; // The placeholder name should be descriptive
            $params['review_text'] = $review_text; // This key matches the placeholder in the prepared statement
        }
        if ($currentReview['review_date'] !== $review_date) {
            $updates[] = "review_date = :review_date";
            $params['review_date'] = $review_date;
        }
        if ($currentReview['quality'] !== $quality) {
            $updates[] = "quality = :quality";
            $params['quality'] = $quality;
        }
        if ($currentReview['location'] !== $location) {
            $updates[] = "location = :location";
            $params['amenities'] = $amenities;
        }
        if ($currentReview['affordability'] !== $affordability) {
            $updates[] = "affordability = :affordability";
            $params['affordability'] = $affordability;
        }
        // Add checks for the rest of the fields like affordability, location, quality...

        // If there are updates, proceed to update the database
        if (count($updates) > 0) {
            $sqlUpdate = "UPDATE reviews SET " . implode(', ', $updates) . " WHERE review_id = :review_id";
            $params['review_id'] = $review_id;
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->execute($params);

            // Redirect or inform the user of success
            echo "<script>alert('Review updated successfully.'); window.location = '../frontend/items.php';</script>";
        } else {
            // Redirect or inform the user that no changes were made
            echo "<script>alert('No changes detected.'); window.location = '../frontend/items.php';</script>";
        }
    } else {
        echo "<script>alert('Review not found.'); window.location = '../frontend/items.php';</script>";
    }
} else {
    // If not a POST request, redirect or handle error
    echo "<script>alert('Invalid request method.'); window.location = '../frontend/items.php';</script>";
}
?>
