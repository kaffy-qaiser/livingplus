<?php
include '../backend/db.php';



// Retrieve listing details from the database
$query = "SELECT id, name, address, picture_url, price FROM listings";
$result = pg_query($dbHandle, $query);

// Store the listing details in an array
$listings = array();
while ($row = pg_fetch_assoc($result)) {
    $listings[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Search Page </title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/search.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="search-filters">
    <form class="filter-form" action="search.php" method="GET">
        <input type="text" id="search-bar" name="name" placeholder="Search by name...">

        <label for="price-range">Price Range:</label>
        <input type="range" id="price-range" name="price" min="0" max="2000" step="50" value="1000" oninput="updateOutput('price-range', 'priceOutputId')">
        <output id="priceOutputId">1000</output>

        <label for="bath-range">Baths:</label>
        <input type="range" id="bath-range" name="baths" min="0" max="12" step="1" value="1" oninput="updateOutput('bath-range', 'bathOutputId')">
        <output id="bathOutputId">1</output>

        <label for="bed-range">Beds:</label>
        <input type="range" id="bed-range" name="beds" min="0" max="12" step="1" value="1" oninput="updateOutput('bed-range', 'bedOutputId')">
        <output id="bedOutputId">1</output>

        <button type="submit">Search</button>
    </form>
</div>

<div class="container">
    <div class="listing-section">
        <div id="listing-cards"></div>
    </div>
    <div class="map-section">
        <div id="map"></div>
    </div>
</div>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpy3Oztzuh0AbMjeDRMACMTzejudEj9R0&callback=initMap"></script>

<script>
    var listings = <?php echo json_encode($listings); ?>;

    function initMap() {
        var mapOptions = {
            center: { lat: 38.03330863055441, lng: -78.50840395966611 },
            zoom: 14
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Create markers and listing cards for each listing
        listings.forEach(function (listing, index) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': listing.address }, function (results, status) {
                if (status === 'OK') {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: listing.name
                    });

                    // Create an info window for the marker
                    var infoWindow = new google.maps.InfoWindow({
                        content: '<h3>' + listing.name + '</h3><p>' + listing.address + '</p>'
                    });

                    // Open the info window when the marker is clicked
                    marker.addListener('click', function () {
                        infoWindow.open(map, marker);
                        highlightCard(index); // Highlight the corresponding card
                    });

                    // Create a card for the listing
                    var card = '<div class="card mb-3" data-index="' + index + '">' +
                        '<img src="' + listing.picture_url + '" class="card-img-top" alt="' + listing.name + '">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + listing.name + '</h5>' +
                        '<p class="card-text">' + listing.address + '</p>' +
                        '<a href="view_reviews.php?id=' + listing.id + '" class="btn btn-primary">View Reviews</a>' +
                        '</div>' +
                        '</div>';

                    // Append the card to the listing cards container
                    document.getElementById('listing-cards').innerHTML += card;
                }
            });
        });
    }

    function highlightCard(index) {
        var cards = document.querySelectorAll('.card');
        cards.forEach(function (card) {
            card.classList.remove('highlight');
        });

        var selectedCard = document.querySelector('.card[data-index="' + index + '"]');
        if (selectedCard) {
            selectedCard.classList.add('highlight');
            selectedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
