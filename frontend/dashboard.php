
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
    <link rel="stylesheet" type="text/css" href="styles/search.css">
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
                <a href="reviews.php">
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
    <main class="container">
        <div class="row">
            <div class="col-12"> 
                <h1>Welcome back,</h1>
                <?php
                // Ensure the session is started (it should be if coming from validate_login.php)
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                // Display the username stored in the session
                // Ensure you check if it's set to avoid errors
                if (isset($_SESSION['username'])) {
                    echo "<h1 class=\"larger-h1\">" . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . "</h1>";
                } else {
                    // If the username isn't set in the session, display a generic message or redirect
                    echo "<h1 class=\"larger-h1\">User</h1>";
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Groups</h5>
                        <p class="card-text">Updates regarding group information.</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Favorites</h5>
                        <p class="card-text">View saved items.</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
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

