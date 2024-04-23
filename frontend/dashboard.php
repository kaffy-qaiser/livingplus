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
        .highlighted {
            border-color: #ff9800; /* Highlight color */
            background-color: #ddd; /* Darker background when highlighted */
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); /* Optional: adds shadow for more depth */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main class="container">
        <div class="row">
            <div class="col-12"> 
                <h1>Welcome back,</h1>
                <?php
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
                <div class="card" id="groupCard">
                    <div class="card-body">
                        <h5 class="card-title">Groups</h5>
                        <p class="card-text">Updates regarding group information.</p>
                        <a href="groups.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card" id="itemCard">
                    <div class="card-body">
                        <h5 class="card-title">Items</h5>
                        <p class="card-text">View your reviews and favorites!</p>
                        <a href="items.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Adding event listeners to highlight cards on mouseover
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('highlighted');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('highlighted');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
