<?php

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS requests
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

// Include the file to establish the database connection
include 'db.php';

$formDataArray = array();


// Check if tableName and formData are set in the POST request
if (isset($_POST['tableName']) && isset($_POST['formData'])) {
    $tableName = $_POST['tableName'];
    $formData = $_POST['formData'];

    $formDataArray = array();

    // Unserialize the form data
    parse_str($formData, $formDataArray);

    // Proceed with database connection and query only if tableName and formData are set
    connectToDatabase(); // Call the function to establish the database connection

    // Escape each value in the formData array
    $escapedFormData = array_map(function ($value) use ($link) {
        return mysqli_real_escape_string($link, $value);
    }, $formDataArray);

    // Prepare SQL query to insert data into the specified table
    $sql = "INSERT INTO $tableName VALUES ('" . implode("', '", $escapedFormData) . "')";

   



    // Execute the SQL query
    $result = mysqli_query($link, $sql);

    // Check if the insertion was successful
    if ($result) {

        echo implode(',', $escapedFormData) ;


        // Return a success message

    } else {
        // Return an error message if insertion failed
       

           echo 'Error inserting record: ' . mysqli_error($link);
        

    }

    // Close the database connection
    mysqli_close($link);
} else {
    // Return an error message if tableName or formData is not set
    echo "Error: tableName or formData parameter is not set.";
}
