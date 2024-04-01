<?php
// Include the database connection from 'db.php'
include '../backend/db.php';

// Initialize an empty array for housing data
$housingData = [];

try {
    // Prepare a SQL query to select housing information
    $sql = "SELECT id, name, address FROM listings"; // Adjust your table and column names accordingly
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Fetch all housing data
    $housingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <main class="container">
        <div class="grid-container">
            <h1>Housing Reviews</h1>
            <!-- Additional static or dynamic content here -->
        </div>
        
        <div class="row">
            <?php foreach ($housingData as $housing): ?>
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($housing['name']); ?></h5>
                            <p class="card-text">Address: <?= htmlspecialchars($housing['address']); ?></p>
                            <!-- You can add more dynamic content here, such as ratings or reviews -->
                            <button type="button" class="btn btn-primary" onclick="window.location.href='view_reviews.php?id=<?= urlencode($housing['id']); ?>'">View Reviews</button>
                            <a href="add_review.php?name=<?= urlencode($housing['name']); ?>" class="btn btn-secondary">Add Review</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>