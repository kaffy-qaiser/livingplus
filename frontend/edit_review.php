<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'navbar.php';
include '../backend/db.php';  

// Get review_id from the query string and sanitize it
$review_id = isset($_GET['review_id']) ? intval($_GET['review_id']) : 0;
// Initialize review array
$review = [];

if ($dbHandle) {
    // Prepare and execute the query to get the specific review
    $result = pg_prepare($dbHandle, "fetch_review", "SELECT reviews.*, listings.name AS listing_name FROM reviews JOIN listings ON reviews.listing_id = listings.id WHERE reviews.id = $1");
    $result = pg_execute($dbHandle, "fetch_review", array($review_id));
    
    if ($result) {
        // Fetch the review data
        $review = pg_fetch_assoc($result);
        if (!$review) {
            echo "<script>alert('Review not found.'); window.location = 'reviews.php';</script>";
            exit;
        } 
    } 
} else {
    exit; // Or handle the error as appropriate
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
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/add_review.css">
    <link rel="stylesheet" type="text/css" href="styles/search.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h2 class="title"><?= $review['listing_name']; ?></h2>
        <form action="../backend/update_review.php" method="post">
            <input type="hidden" name="reviewId" value="<?= $review['id']; ?>"/>
            <div class="inputs">
                <input type="text" name="reviewTitle" placeholder="Title" class="input-title" value="<?= $review['review_title']; ?>"/>
                <input type="date" name="reviewDate" class="input-date" value="<?= $review['review_date']; ?>"/>
            </div>
            <div class="textarea-container">
                <textarea placeholder="Type the review here..." name="reviewText" id="reviewTextArea" oninput="updateWordCount()"><?= $review['review']; ?></textarea>
                <div class="word-count-display">
                    <span id="wordCount">0</span>/100 words
                </div>
            </div>
            <div class="sliders">
                <!-- Amenities slider -->
                <div class="slider-container">
                    <label for="amenitiesSlider">Amenities: <span id="amenitiesSliderValue"><?= $review['amenities']; ?></span></label>
                    <input type="range" min="1" max="10" class="slider" name="amenities" id="amenitiesSlider" value="<?= $review['amenities']; ?>" oninput="updateSliderValue(this.id, this.value)">
                </div>
                <!-- Affordability slider -->
                <div class="slider-container">
                    <label for="affordabilitySlider">Affordability: <span id="affordabilitySliderValue"><?= $review['affordability']; ?></span></label>
                    <input type="range" min="1" max="10" class="slider" name="affordability" id="affordabilitySlider" value="<?= $review['affordability']; ?>" oninput="updateSliderValue(this.id, this.value)">
                </div>
                <!-- Quality slider -->
                <div class="slider-container">
                    <label for="qualitySlider">Quality: <span id="qualitySliderValue"><?= $review['quality']; ?></span></label>
                    <input type="range" min="1" max="10" class="slider" name="quality" id="qualitySlider" value="<?= $review['quality']; ?>" oninput="updateSliderValue(this.id, this.value)">
                </div>
                <!-- Location slider -->
                <div class="slider-container">
                    <label for="locationSlider">Location: <span id="locationSliderValue"><?= $review['location']; ?></span></label>
                    <input type="range" min="1" max="10" class="slider" name="location" id="locationSlider" value="<?= $review['location']; ?>" oninput="updateSliderValue(this.id, this.value)">
                </div>
            </div>
            <div class="action-buttons">
                <a href="reviews.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Review</button>
            </div>
        </form>
    </div>


    <script>
        document.querySelectorAll('.slider').forEach(function(slider) {
            slider.oninput = function() {
                document.getElementById(slider.id + 'Value').innerText = slider.value;
            };
        });
    </script>
    <script>
        function updateWordCount() {
            var textarea = document.getElementById('reviewTextArea');
            var wordCount = 0;
            var words = textarea.value.match(/\b[-?(\w+)?]+\b/gi);
            if (words) {
                wordCount = words.length;
                if (wordCount > 100) {
                    textarea.value = words.slice(0, 100).join(' ');
                    wordCount = 100;
                }
            }
            document.getElementById('wordCount').innerText = wordCount;
        }
    </script>
    <script>
        function updateSliderValue(sliderId, value) {
            document.getElementById(sliderId + 'Value').innerText = value;
        }

        // Initialize the sliders' values on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSliderValue('amenitiesSlider', document.getElementById('amenitiesSlider').value);
            updateSliderValue('affordabilitySlider', document.getElementById('affordabilitySlider').value);
            updateSliderValue('qualitySlider', document.getElementById('qualitySlider').value);
            updateSliderValue('locationSlider', document.getElementById('locationSlider').value);
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
