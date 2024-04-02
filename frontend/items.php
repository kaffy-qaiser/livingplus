
<?php
    // Start the session at the top of the file
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Living+</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <style>
        body, h1, h2, h3, h4, h5, p {
            font-family: 'Catamaran', sans-serif;
            font-style: normal;
        }
        .card {
            border: 1px solid blue;
        }
        .container {
            max-width: 80%; 
            margin: auto;
            padding-top: 30px;
        }
        h1 {
            text-align: left;
            margin-left: 0; 
        }
        .larger-h1 {
            font-size: 2.5em;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main class="container">
    <?php
    include '../backend/db.php';  // Include your database connection
    
    // Check if the user_id is set in the session
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Prepare and execute the query to get reviews and listing names for the logged-in user
        $stmt = $conn->prepare(
            "SELECT reviews.*, listings.name AS listing_name 
             FROM reviews 
             JOIN listings ON reviews.listing_id = listings.id 
             WHERE reviews.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $user_id]);

        // Fetch the reviews and listing names
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each review and create a card with an edit button and listing name
        foreach ($reviews as $review) {
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($review['listing_name']) . '</h5>';  // Display listing name
            echo '<h6 class="card-subtitle mb-2 text-muted">Date: ' . htmlspecialchars($review['review_date']) . '</h6>';
            echo '<p class="card-text">' . htmlspecialchars($review['review']) . '</p>';
            echo '<p class="card-text">Amenities: ' . htmlspecialchars($review['amenities']) . '</p>';
            echo '<p class="card-text">Affordability: ' . htmlspecialchars($review['affordability']) . '</p>';
            echo '<p class="card-text">Location: ' . htmlspecialchars($review['location']) . '</p>';
            echo '<p class="card-text">Quality: ' . htmlspecialchars($review['quality']) . '</p>';
            // Edit button. Assuming you have an edit_review.php page that handles the editing
            echo '<a href="edit_review.php?review_id=' . htmlspecialchars($review['review_id']) . '&listing_id=' . htmlspecialchars($review['listing_id']) . '" class="btn btn-primary">Edit Review</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>You need to be logged in to see this page.</p>';
    }
    ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

