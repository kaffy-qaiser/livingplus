<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Database connection parameters
    $host = "localhost";
    $port = "5432";
    $database = "example";
    $user = "kaffyqaiser";
    $password = "cs4640LocalUser!";


// Establishing a connection to the database
    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
       // echo "Success connecting to the database.\n";
    } else {
        echo "An error occurred connecting to the database.\n";
        exit;
    }

    // // Truncate tables and disable triggers
    // $truncateTables = "
    //     TRUNCATE TABLE reviews, listings, login RESTART IDENTITY CASCADE;
    // ";
    // pg_query($dbHandle, $truncateTables) or die('Truncate failed: ' . pg_last_error($dbHandle));
    
    

    // SQL to create login table
    $createLoginTable = "
        CREATE TABLE IF NOT EXISTS login (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
    ";

    // SQL to create an updated listings table with additional fields
    $createListingsTable = "
        CREATE TABLE IF NOT EXISTS listings (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        address VARCHAR(255) NOT NULL,
        picture_url VARCHAR(255),   -- Assuming image URLs will not exceed 255 characters
        near_places VARCHAR(255),   -- A simple text field; consider increasing size if needed
        listing_url VARCHAR(255),   -- URL for the listing website
        max_baths INTEGER,          -- Max number of bathrooms
        max_beds INTEGER,           -- Max number of bedrooms
        price NUMERIC(10, 2)        -- Assuming price could have two decimal places
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

    // SQL to create groups table
    $createGroupsTable = "
        CREATE TABLE IF NOT EXISTS groups (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            description TEXT
        );
    ";

    $createGroupMembershipsTable = "
        CREATE TABLE IF NOT EXISTS group_memberships (
            group_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES login(id) ON DELETE CASCADE,
            PRIMARY KEY (group_id, user_id)
        );
    ";

    $createLikedTable = "
        CREATE TABLE IF NOT EXISTS Liked (
            UserID INT NOT NULL,
            ListingID INT NOT NULL,
            PRIMARY KEY (UserID, ListingID),
            FOREIGN KEY (UserID) REFERENCES login(id),
            FOREIGN KEY (ListingID) REFERENCES listings(id)); ";


    // Execute table creation SQL
    pg_query($dbHandle, $createLoginTable) or die('Login table creation failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createListingsTable) or die('Listings table creation failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createReviewsTable) or die('Reviews table creation failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createGroupsTable) or die('Groups table creation failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createGroupMembershipsTable) or die('Group memberships table creation failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $createLikedTable) or die('Liked table creation failed: ' . pg_last_error($dbHandle));



    // Insert dummy data into login table with conflict handling
    $insertLoginData = "
         INSERT INTO login (username, password) VALUES
            ('user1', 'pass1'),
            ('user2', 'pass2')
     ";

    $insertListingsData = "
        INSERT INTO listings (
            name, 
            address, 
            picture_url, 
            near_places, 
            listing_url, 
            max_baths, 
            max_beds, 
            price
        ) VALUES (
            'The Standard At Charlottesville', 
            '853 West Main Street, Charlottesville, VA 22903', 
            'https://img.offcampusimages.com/1ZpyQdjz_--ak8uyw8qIONvepz4=/660x440/left/top/smart/images/56h2k9megwi7bs2vwbgeeihgwbzu3ejbfoclb2ulwds.jpeg', 
            'The Corner, The Rotunda, Potbelly', 
            'https://offgroundshousing.student.virginia.edu/housing/property/the-standard-at-charlottesville/ocphqg8yd1', 
            4, 
            4, 
            1350
        )
        ON CONFLICT (name) DO NOTHING;
    ";


    // Execute data insertion SQL
   // pg_query($dbHandle, $insertLoginData) or die('Login data insertion failed: ' . pg_last_error($dbHandle));
    pg_query($dbHandle, $insertListingsData) or die('Listings data insertion failed: ' . pg_last_error($dbHandle));
    //pg_query($dbHandle, $insertLoginData) or die('Login data insertion failed: ' . pg_last_error($dbHandle));


    // echo "Data insertion successful, excluding reviews.\n";
?>
