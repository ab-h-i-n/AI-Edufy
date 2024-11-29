<?php
include_once("../../utils/connect.php");

$create_table_query = "CREATE TABLE IF NOT EXISTS TEST (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    image BLOB NULL 
) AUTO_INCREMENT=1000";

// Execute the query to create the table
if ($dbcon->query($create_table_query) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $dbcon->error . "<br>";
}

// Query to retrieve data from the TEST table
$get_data_query = "SELECT * FROM TEST";

// Execute the query
$result = $dbcon->query($get_data_query);

if ($result) {
    // Loop through the result set and output the data
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        // Echo the 'id'
        echo "ID: " . $row['id'] . "<br>";

        // If you want to display the image, encode it in base64 to make it displayable
        if ($row['image']) {
            // Base64 encode the image data to make it viewable
            $encoded_image = base64_encode($row['image']);
            echo "<img src='data:image/jpeg;base64,{$encoded_image}' alt='Image'><br>";
        } else {
            echo "No image available<br>";
        }
    }
} else {
    echo "Error retrieving data: " . $dbcon->error . "<br>";
}

// Close the database connection
$dbcon->close();
?>
