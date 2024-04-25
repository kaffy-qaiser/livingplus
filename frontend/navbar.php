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
    <link rel="stylesheet" type="text/css" href="styles/navbar.css">
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
            <a href="search.php">
                <i class='bx bx-search'></i>
                <span class="links_name">Search</span>
            </a>
            <span class="tooltip">Search</span>
        </li>
        <li>
            <a href="reviews.php">
                <i class='bx bx-compass'></i>
                <span class="links_name">Listings</span>
            </a>
            <span class="tooltip">Listings</span>
        </li>
        <li>
            <a href="">
                <i class='bx bx-heart'></i>
                <span class="links_name">Favorites</span>
            </a>
            <span class="tooltip">Favorites</span>
        </li>
        <li>
            <a href="groups.php">
                <i class='bx bx-chat'></i>
                <span class="links_name">Groups</span>
            </a>
            <span class="tooltip">Groups</span>
        </li>
        <li>
            <a href="items.php">
                <i class='bx bx-user'></i>
                <span class="links_name">My Reviews</span>
            </a>
            <span class="tooltip">My Reviews</span>
        </li>
        <li class="logout">
            <a href="../backend/logout.php">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Logout</span>
            </a>
            <span class="tooltip">Logout</span>
        </li>

    </ul>
</div>
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

        (function() {
            const a = 5;
            const b = 10;
            const result = a * b + 2;
        })();

    </script>
</body>
</html>

