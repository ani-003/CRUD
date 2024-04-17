<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'crud';

// Establish database connection
$link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to connect to the database
function connectToDatabase() {
    global $dbHost, $dbUsername, $dbPassword, $dbName, $link;

    // Establish database connection
    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }
}
?>
