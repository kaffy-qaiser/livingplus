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
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="wrapper">
<main class="container">
    <header style=" margin-bottom: 40px;">
        <h1>Welcome back, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User' ?></h1>
    </header>
    <section class="cards">
        <div class="card" style="background-color: black" id="groupCard">
            <h2>Groups</h2>
            <p>Updates regarding group information.</p>
            <a href="groups.php">View</a>
        </div>
        <div class="card" style="background-color: black" id="itemCard">
            <h2>Items</h2>
            <p>View your reviews and favorites!</p>
            <a href="items.php">View</a>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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
</body>
</html>