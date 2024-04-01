<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Search Page </title>
    <link rel="stylesheet" href="styles/search.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="search-filters">
    <form class="filter-form">
        <input type="text" id="search-bar" placeholder="Search...">

        <select id="neighborhood-dropdown">
            <option value="">Neighborhood</option>
            <option value="JPA">JPA</option>
            <option value="The Corner">The Corner</option>
        </select>

        <label for="price-range">Price Range:</label>
        <input type="range" id="price-range" name="price" min="0" max="2000" step="50" value="1000" oninput="updateOutput('price-range', 'priceOutputId')">
        <output id="priceOutputId">1000</output>

        <label for="bath-range">Baths:</label>
        <input type="range" id="bath-range" name="baths" min="0" max="20" step="1" value="1" oninput="updateOutput('bath-range', 'bathOutputId')">
        <output id="bathOutputId">1</output>

        <label for="bed-range">Beds:</label>
        <input type="range" id="bed-range" name="beds" min="0" max="20" step="1" value="1" oninput="updateOutput('bed-range', 'bedOutputId')">
        <output id="bedOutputId">1</output>


        <button type="submit">Search</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
