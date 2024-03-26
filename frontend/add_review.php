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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/add_review.css">
    <link rel="stylesheet" type="text/css" href="styles/search.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="images/logo.png" alt="Logo" class="logo" onclick="closeSidebar()">
            <i class='bx bx-plus' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="dashboard.php">
                    <i class='bx bx-home'></i>
                    <span class="links_name">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="search.html">
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
                <a href="reviews.html">
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
            <li class="logout">
                <a href="/backend/logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
    
        </ul>
    </div>
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
                <div class="left-sliders">
                    <div class="slider-container">
                        <span class="slider-label">Quality</span>
                        <input type="range" min="1" max="10" class="slider" name="quality" id="slider1">
                        <span id="slider1Value">5</span>
                    </div>
                    <div class="slider-container">
                        <span class="slider-label">Location</span>
                        <input type="range" min="1" max="10" class="slider" name="location" id="slider2">
                        <span id="slider2Value">5</span>
                    </div>
                </div>
                <div class="right-sliders">
                    <div class="slider-container">
                        <span class="slider-label">Affordability</span>
                        <input type="range" min="1" max="10" class="slider" name="affordability" id="slider3">
                        <span id="slider3Value">5</span>
                    </div>
                    <div class="slider-container">
                        <span class="slider-label">Amenities</span>
                        <input type="range" min="1" max="10" class="slider" name="amenities" id="slider4">
                        <span id="slider4Value">5</span>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="reviews.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Review</button>
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--  The navbar was taken from this youtube video: https://www.youtube.com/watch?v=wEfaoAa99XY-->
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
