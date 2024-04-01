
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

</body>
</html>

