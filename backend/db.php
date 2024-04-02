<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$host = "localhost";
$port = "5432";
$database = "hws7ug";
$user = "hws7ug";
$password = "pCfxODw_OGww";

// Connection string
$connectionString = "host=$host port=$port dbname=$database user=$user password=$password";

// Attempt to connect to the PostgreSQL database
$dbHandle = pg_connect($connectionString);

// Function to create tables
function createTables($dbHandle) {
    // SQL to create login table
    $createLoginTable = "
        CREATE TABLE IF NOT EXISTS login (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
    ";

    // SQL to create listings table with unique name
    $createListingsTable = "
        CREATE TABLE IF NOT EXISTS listings (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            address VARCHAR(255) NOT NULL
        );
    ";

    // SQL to create reviews table
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

    $insertDefaultUserSQL = "
        INSERT INTO login (username, password)
        SELECT 'user', 'pass'
        WHERE NOT EXISTS (
            SELECT 1 FROM login WHERE username = 'user'
        );
    ";

    // Execute SQL commands for table creation
    pg_query($dbHandle, $createLoginTable) or die('Query failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createListingsTable) or die('Query failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createReviewsTable) or die('Query failed: ' . pg_last_error($dbHandle));
    // pg_query($dbHandle, $insertDefaultUserSQL) or die('Query failed: ' . pg_last_error($dbHandle));

    
    // DO NOT UNCOMMENT
    //insertBasicListings($dbHandle);
}

// Function to insert basic listings
function insertBasicListings($dbHandle) {
    $insertListingsSQL = "
        INSERT INTO listings (name, address) VALUES
        ('Shifty Shafts', '123 Main St'),
        ('Tilted Towers', '456 Market St'),
        ('Junk Junction', '789 Broadway St')
    ";

    // Execute SQL command to insert listings
    pg_query($dbHandle, $insertListingsSQL) or die('Query failed: ' . pg_last_error($dbHandle));
}

if ($dbHandle) {
    createTables($dbHandle);
} else {
    echo "An error occurred connecting to the database: " . pg_last_error($dbHandle);
}

?>
