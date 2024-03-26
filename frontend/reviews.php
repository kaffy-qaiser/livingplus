<?php
// Include the database connection from 'db.php'
include '../backend/db.php';

// Initialize an empty array for housing data
$housingData = [];

try {
    // Prepare a SQL query to select housing information
    $sql = "SELECT name, address FROM listings"; // Adjust your table and column names accordingly
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
    <div class="sidebar">
        <div class="logo-details">
            <img src="images/logo.png" alt="Logo" class="logo" onclick="closeSidebar()">
            <i class='bx bx-plus' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="#">
                    <i class='bx bx-home'></i>
                    <span class="links_name">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-search'></i>
                    <span class="links_name">Search</span>
                </a>
                <span class="tooltip">Search</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-heart'></i>
                    <span class="links_name">Favorites</span>
                </a>
                <span class="tooltip">Favorites</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-chat'></i>
                    <span class="links_name">Messages</span>
                </a>
                <span class="tooltip">Messages</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-star'></i>
                    <span class="links_name">Reviews</span>
                </a>
                <span class="tooltip">Reviews</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-compass'></i>
                    <span class="links_name">Explore</span>
                </a>
                <span class="tooltip">Explore</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <li class="profile">
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
    
        </ul>
    </div>
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
                            <button type="button" class="btn btn-primary">View Reviews</button>
                            <a href="add_review.php?name=<?= urlencode($housing['name']); ?>" class="btn btn-secondary">Add Review</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <!--  The navbar was taken from this youtube video: https://www.youtube.com/watch?v=wEfaoAa99XY-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchFilters = document.querySelector(".search-filters");
    
        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();
            adjustSearchFilters();
        });
    
        function menuBtnChange() {
            if(sidebar.classList.contains("open")){
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            }else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    
        function adjustSearchFilters() {
            const sidebarWidth = sidebar.classList.contains("open") ? 250 : 78;
            const searchFiltersWidth = window.innerWidth - sidebarWidth;
    
            searchFilters.style.width = `${searchFiltersWidth}px`;
    
            searchFilters.style.marginLeft = `${sidebarWidth}px`;
        }
    
        document.addEventListener("DOMContentLoaded", adjustSearchFilters);
        closeBtn.addEventListener("click", adjustSearchFilters);
        window.addEventListener('resize', adjustSearchFilters);
    
        function updateOutput(sliderId, outputId) {
            var slider = document.getElementById(sliderId);
            var output = document.getElementById(outputId);
            output.value = slider.value;
        }
    
        function closeSidebar() {
            sidebar.classList.remove("open");
            menuBtnChange();
            adjustSearchFilters();
        }
    
    </script>
</body>
</html>
