<?php
include '../backend/db.php';
session_start(); // Start the session

// Initialize an empty array for housing data
$housingData = [];

if ($dbHandle) {
    try {
        // Prepare a SQL query to select housing information
        $result = pg_query($dbHandle, "SELECT id, name, address, picture_url, near_places, listing_url, 
            max_baths, max_beds, price FROM listings");
        if (!$result) {
            throw new Exception("Query failed: " . pg_last_error($dbHandle));
        }

        // Fetch all housing data
        $housingData = pg_fetch_all($result, PGSQL_ASSOC);
        if (empty($housingData)) {
            echo "<script>document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('noDataAlert').style.display = 'block';
            });</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
    }
} else {
    echo "<script>alert('Database connection not established.');</script>";
}

// Search functionality
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    $filteredHousingData = array_filter($housingData, function ($housing) use ($searchTerm) {
        return stripos($housing['name'], $searchTerm) !== false;
    });

    $housingData = $filteredHousingData;
}

// Check if the user is logged in
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle like/unlike functionality
if (isset($_POST['action']) && isset($_POST['listingId'])) {
    $action = $_POST['action'];
    $listingId = $_POST['listingId'];

    if ($action === 'like') {
        // User wants to like the listing
        $query = "INSERT INTO Liked (UserID, ListingID) VALUES ($1, $2)";
        $result = pg_query_params($dbHandle, $query, array($userId, $listingId));

        if ($result) {
            echo "<script>alert('Listing liked successfully.');</script>";
        } else {
            echo "<script>alert('Error liking the listing: " . pg_last_error($dbHandle) . "');</script>";
        }
    } elseif ($action === 'unlike') {
        // User wants to unlike the listing
        $query = "DELETE FROM Liked WHERE UserID = $1 AND ListingID = $2";
        $result = pg_query_params($dbHandle, $query, array($userId, $listingId));

        if ($result) {
            echo "<script>alert('Listing unliked successfully.');</script>";
        } else {
            echo "<script>alert('Error unliking the listing: " . pg_last_error($dbHandle) . "');</script>";
        }
    }
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

    <link rel="stylesheet" type="text/css" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/reviews.css">
    <style>
        .search-container {
            width: 70%;
            display: flex;
            justify-content: right;
            gap: 20px;
        }

        .search-container input[type="text"] {
            width: 58%;
            padding: 10px;
            border: 2px solid #DDE2E5;
            border-radius: 25px;
            font-size: 16px;
        }

        .search-container button {
            padding: 10px 20px;
            border-radius: 25px;
            border: none;
            background-color: black;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .search-container button:hover {
            background-color: #464646;
        }

    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="container">
        <div class="grid-container">
            <h1>Housing Reviews</h1>
            <div class="search-container">
                <form action="" method="GET">
                    <input type="text" placeholder="Enter Listing.." name="search" value="<?= htmlspecialchars($searchTerm); ?>" style="width: 350px">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
        <div id="noDataAlert" class="alert alert-warning" style="display:none;">
            No housing data available at the moment.
        </div>

        <div class="flex-container">
            <?php if (!empty($housingData)): foreach ($housingData as $housing): ?>
                <div class="card-container">
                    <div class="review-card">
                        <div class="card-content">
                            <div class="card-image">
                                <img src="<?= html_entity_decode($housing['picture_url']); ?>" alt="Image of <?= html_entity_decode($housing['name']); ?>" class="img-fluid" style=" width: 300px" >
                            </div>
                            <div class="card-info">
                                <h5 class="card-heading"><?= htmlspecialchars($housing['name']); ?></h5>
                                <p class="address-text">Address: <?= preg_replace('/^(.*)$/', '$1', html_entity_decode($housing['address'])); ?></p>
                            </div>
                            <div class="action-buttons">
                                <button type="button" class="like-btn" >Like Housing</button>
                                <button type="button" class="add-btn" onclick="window.location.href='<?php echo html_entity_decode($housing['listing_url']); ?>'">Learn More</button>
                                <button type="button" class="view-btn" onclick="window.location.href='view_reviews.php?id=<?= urlencode($housing['id']); ?>'">View Reviews</button>
                                <button type="button" class="view-btn" onclick="window.location.href='add_review.php?name=<?= urlencode($housing['name']); ?>'">Add Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <script>document.getElementById('noDataAlert').style.display = 'block';</script>
            <?php endif; ?>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $(".like-btn").click(function() {
                $(this).toggleClass('active');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>
