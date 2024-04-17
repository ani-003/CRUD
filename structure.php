<?php
include 'db.php';

// Check if tableName parameter is set
if(isset($_GET['tableName'])) {
    $tableName = $_GET['tableName'];

    // Proceed with database connection and query only if tableName is set
    connectToDatabase(); // Call the function to establish the database connection

    header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS requests
    header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

    $query = "SHOW COLUMNS FROM $tableName";
    $result = mysqli_query($link, $query);

    if($result) {
        // Fetch the column names
        $columns = array();
        while($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }

        // Output the column names as plain text
        echo implode(',', $columns);
    } else {
        // Handle query execution error
        echo "Error: " . mysqli_error($link);
    }
} else {
    // Handle case where tableName parameter is not set
    echo "Error: tableName parameter is not set.";
}
?>
