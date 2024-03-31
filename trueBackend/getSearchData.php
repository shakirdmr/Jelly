<?php
// b.php

// Process the search query
$query = $_GET['query'];


// Perform necessary actions with the query to get data
// Here, let's assume we're retrieving some sample data
$data = array(
    array('name' => 'John', 'email' => 'john@example.com'),
    array('name' => 'Alice', 'email' => 'alice@example.com'),
    // Add more data as needed
);

// Encode the data as JSON
$response = json_encode($data);

// Send the JSON response back to a.php
echo $response;
?>
