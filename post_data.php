<?php

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS requests
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

// Include the file to establish the database connection
include 'db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the table name is provided in the form data
    if (isset($_POST["tab_name"])) {
        $tableName = $_POST["tab_name"];
        
        // Check if any fields were provided
        if (isset($_POST["field1"]) && isset($_POST["type1"])) {
            // Initialize arrays to store the field names and types
            $fields = array();
            $types = array();
            
            // Loop through the $_POST array to extract field names and types
            foreach ($_POST as $key => $value) {
                // Check if the key starts with "field" indicating a field name
                if (strpos($key, "field") === 0) {
                    $fields[] = $value;
                }
                // Check if the key starts with "type" indicating a field type
                if (strpos($key, "type") === 0) {
                    $types[] = $value;
                }
            }
            
            // Initialize an array to store the field definitions
            $fieldDefinitions = array();
            
            // Combine field names and types to form the field definitions
            for ($i = 0; $i < count($fields); $i++) {
                $fieldDefinitions[] = $fields[$i] . ' ' . $types[$i];
            }
            
            // Prepare the SQL query to create the table
            $sql = "CREATE TABLE $tableName (". implode(',', $fieldDefinitions) .")";
            
            // Execute the SQL query to create the table
            $result = mysqli_query($link, $sql);
            
            // Check if the table creation was successful
            if ($result) {
                echo "Table '$tableName' created successfully.";
                // Redirect the user to structure.php with the table name encoded in the URL query string
                header("Location: structure.php?tableName=" . urlencode($tableName));
                exit();
            } else {
                // If there's an error during table creation, echo an error message
                echo "Error creating table: " . mysqli_error($link);
            }
        } else {
            // If no fields were provided, echo an error message
            echo "Error: No fields provided.";
        }
    } else {
        // If no table name is provided, echo an error message
        echo "Error: No table name provided.";
    }
} else {
    // If the request method is not POST, echo an error message
    echo "Error: Only POST requests are allowed.";
}

// Close the database connection (if required)
mysqli_close($link);
?>
