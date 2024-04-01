<?php
include '../backend/db.php'; // Adjust the path as needed

$listingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$reviewsData = [];

try {
    // Adjust your SQL query to match your table structure
    $sql = "SELECT review_id, affordability, location, amenities, quality, review_title, review 
            FROM reviews 
            WHERE listing_id = :listingId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();

    $reviewsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
    <link rel="stylesheet" type="text/css" href="styles/search.css">
    <link rel="stylesheet" href="styles/reviews.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Reviews</h1>
        <div class="row">
            <?php foreach ($reviewsData as $review): ?>
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($review['review_title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($review['review']); ?></p>
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
        </div>
        <!-- Add this at the bottom of your main container, just before the closing tag -->
        <div class="back-button-container" style="margin-top: 20px;">
            <a href="reviews.php" class="btn btn-secondary">Back to Listings</a>
        </div>
    </div>
    
    <!--  The navbar was taken from this youtube video: https://www.youtube.com/watch?v=wEfaoAa99XY-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>