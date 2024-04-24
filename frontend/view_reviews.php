<?php
include '../backend/db.php';

$listingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$reviewsData = [];
$listingData = null;

if ($listingId > 0) {
    try {
        // Fetch reviews for the listing
        $query = "SELECT affordability, location, amenities, quality, review_title, review 
                  FROM reviews 
                  WHERE listing_id = $1";

        $result = pg_prepare($dbHandle, "", $query);
        $result = pg_execute($dbHandle, "", array($listingId));

        if ($result) {
            $reviewsData = pg_fetch_all($result);
        }

        // Fetch listing details
        $query = "SELECT name, picture_url FROM listings WHERE id = $1";
        $result = pg_prepare($dbHandle, "", $query);
        $result = pg_execute($dbHandle, "", array($listingId));

        if ($result) {
            $listingData = pg_fetch_assoc($result);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/view_reviews.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<?php if ($listingData): ?>
    <div class="listing-header">
        <h2><?= htmlspecialchars($listingData['name']); ?></h2>
        <img src="<?= htmlspecialchars($listingData['picture_url']); ?>" alt="Listing Picture" style="width: 400px">
    </div>
<?php endif; ?>

<div class="back-button-container">
    <button type="button" class="back-btn" onclick="window.location.href='reviews.php'">Back</button>
    <button type="button" class="add-btn" onclick="window.location.href='add_review.php?name=<?= urlencode($listingData['name']); ?>'">Add Review</button>
</div>
<div class="container">
    <div class="reviews-grid">
        <?php if (!empty($reviewsData)): ?>
            <?php foreach ($reviewsData as $review): ?>
                <div class="review-card">
                    <h5 class="review-title"><?= html_entity_decode($review['review_title']); ?></h5>
                    <p class="review-text"><?= html_entity_decode($review['review']); ?></p>
                    <ul class="review-details">
                        <li>Affordability: <?= htmlspecialchars($review['affordability']); ?></li>
                        <li>Location: <?= htmlspecialchars($review['location']); ?></li>
                        <li>Amenities: <?= htmlspecialchars($review['amenities']); ?></li>
                        <li>Quality: <?= htmlspecialchars($review['quality']); ?></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p id="noReviewsMsg">No reviews found for this listing.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (!id || isNaN(id) || parseInt(id) <= 0) {
            document.getElementById('noReviewsMsg').textContent = 'Invalid listing ID provided.';
            document.querySelectorAll('.card, .back-button-container').forEach(el => el.style.display = 'none');
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>