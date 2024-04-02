<?php

// Note that these are for the local Docker container
$host = "db";
$port = "5432";
$database = "example";
$user = "localuser";
$password = "cs4640LocalUser!";

$connectionString = "host=$host port=$port dbname=$database user=$user password=$password";
$dbHandle = pg_connect($connectionString);

if ($dbHandle) {
   // echo "Success connecting to database\n";

    // SQL to create tables
    $createLoginTable = "
        CREATE TABLE IF NOT EXISTS login (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        );
    ";

    $createListingsTable = "
        CREATE TABLE IF NOT EXISTS listings (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL
        );
    ";

    $createReviewsTable = "
        CREATE TABLE IF NOT EXISTS reviews (
            id SERIAL PRIMARY KEY,
            listing_id INTEGER NOT NULL,
            review_date DATE NOT NULL,
            amenities INTEGER NOT NULL,
            affordability INTEGER NOT NULL,
            location INTEGER NOT NULL,
            quality INTEGER NOT NULL,
            review TEXT NOT NULL,
            review_title VARCHAR(255) NOT NULL,
            user_id INTEGER NOT NULL,
            FOREIGN KEY (listing_id) REFERENCES listings(id),
            FOREIGN KEY (user_id) REFERENCES login(id)
        );
    ";

    // Execute SQL commands
    pg_query($dbHandle, $createLoginTable) or die('Query failed: ' . pg_last_error());
    pg_query($dbHandle, $createListingsTable) or die('Query failed: ' . pg_last_error());
    pg_query($dbHandle, $createReviewsTable) or die('Query failed: ' . pg_last_error());

   // echo "Tables created successfully";
} else {
    // Using pg_last_error() to get more insight into the connection failure
    $error = pg_last_error($dbHandle);
    echo "An error occurred connecting to the database: " . $error;
}

?>
