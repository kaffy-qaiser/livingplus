<?php
include '../backend/db.php'; 

$listingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$reviewsData = [];

if ($listingId > 0) {
    try {
        
        $query = "SELECT affordability, location, amenities, quality, review_title, review 
                  FROM reviews 
                  WHERE listing_id = $1";

        $result = pg_prepare($dbHandle, "", $query);
        $result = pg_execute($dbHandle, "", array($listingId));

        if ($result) {
            $reviewsData = pg_fetch_all($result);
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
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Reviews</h1>
        <div class="row">
            <?php if (!empty($reviewsData)): ?>
                <?php foreach ($reviewsData as $review): ?>
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= html_entity_decode($review['review_title']); ?></h5>
                                <p class="card-text"><?= html_entity_decode($review['review']); ?></p>
                                <ul>
                                    <li>Affordability: <?= htmlspecialchars($review['affordability']); ?></li>
                                    <li>Location: <?= htmlspecialchars($review['location']); ?></li>
                                    <li>Amenities: <?= htmlspecialchars($review['amenities']); ?></li>
                                    <li>Quality: <?= htmlspecialchars($review['quality']); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noReviewsMsg">No reviews found for this listing.</p>
            <?php endif; ?>
        </div>
        <div class="back-button-container" style="margin-top: 20px;">
            <a href="reviews.php" class="btn btn-secondary">Back to Listings</a>
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
