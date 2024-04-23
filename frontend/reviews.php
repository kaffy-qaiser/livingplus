<?php
// Assuming 'db.php' contains the PostgreSQL connection code shown in your second snippet
include '../backend/db.php'; // Adjust the path as necessary

// Initialize an empty array for housing data
$housingData = [];

if ($dbHandle) {
    try {
        // Prepare a SQL query to select housing information
        $result = pg_query($dbHandle, "SELECT id, name, address FROM listings");
        if (!$result) {
            throw new Exception("Query failed: " . pg_last_error($dbHandle));
        }
        
        // Fetch all housing data
        $housingData = pg_fetch_all($result, PGSQL_ASSOC);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Database connection not established.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    ...
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/reviews.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main class="main-container">
    <div class="grid-container">
        <div class="top-container">
            <h1>Housing Reviews</h1>
            <div class="search-container">
                <input type="text" placeholder="Enter Listing.." name="search">
                <button type="submit">Search here</button>
            </div>
        </div>

    </div>


    <div class="flex-container">
        <?php foreach ($housingData as $housing): ?>
            <div class="card-container">
                <div class="review-card">
                    <div class="card-content">
                        <div class="card-info>">
                            <h5 class="card-heading"><?= htmlspecialchars($housing['name']); ?></h5>
                            <p class="card-description">Address: <?= htmlspecialchars($housing['address']); ?></p>
                            <button type="button" class="like-btn">&#x2764;</button>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="view-btn" onclick="window.location.href='view_reviews.php?id=<?= urlencode($housing['id']); ?>'">View Reviews</button>
                            <button type="button" class="add-btn" onclick="window.location.href='add_review.php?name=<?= urlencode($housing['name']); ?>'" >Add Review</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>
<script>
    // Listen for clicks on like buttons
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('liked'); // Toggle the 'liked' class on click
        });
    });
</script>
</body>
</html>

