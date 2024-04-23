<?php
// Assuming 'name' is passed as a query parameter to this script
$listingName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Unknown Listing';
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

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/add_review.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h2 class="title"><?= $listingName; ?></h2>
    <form action="../backend/insert_review.php" method="post">
        <input type="hidden" name="listingName" value="<?= htmlspecialchars($listingName); ?>"/>
        <div class="inputs">
            <input type="text" name="reviewTitle" placeholder="Title" class="input-title"/>
            <input type="date" name="reviewDate" class="input-date"/>
        </div>
        <div class="textarea-container">
            <textarea placeholder="Type the review here..." name="review" id="reviewTextArea" oninput="updateWordCount()"></textarea>
            <div class="word-count-display">
                <span id="wordCount">0</span>/100 words
            </div>
        </div>
        <div class="sliders">
            <div class="slider-group">
                <div class="slider-container">
                    <label for="slider1" class="slider-label">Quality</label>
                    <input type="range" min="1" max="10" class="slider" name="quality" id="slider1">
                    <span id="slider1Value">5</span>
                </div>
                <div class="slider-container">
                    <label for="slider2" class="slider-label">Location</label>
                    <input type="range" min="1" max="10" class="slider" name="location" id="slider2">
                    <span id="slider2Value">5</span>
                </div>
            </div>
            <div class="slider-group">
                <div class="slider-container">
                    <label for="slider3" class="slider-label">Affordability</label>
                    <input type="range" min="1" max="10" class="slider" name="affordability" id="slider3">
                    <span id="slider3Value">5</span>
                </div>
                <div class="slider-container">
                    <label for="slider4" class="slider-label">Amenities</label>
                    <input type="range" min="1" max="10" class="slider" name="amenities" id="slider4">
                    <span id="slider4Value">5</span>
                </div>
            </div>
        </div>
        <div class="action-buttons">
            <button type="submit" class="button-submit">Add Review</button>
            <button onclick="window.location.href='reviews.php'" class="button-cancel">Cancel</button>
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
</body>
</html>

