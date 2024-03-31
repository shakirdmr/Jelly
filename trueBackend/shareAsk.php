<?php

$userUniqueID = @$_COOKIE["userUniqueID"];
// Assuming $conn is your database connection

require("../assets/db.php");
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the found_id parameter exists in the POST request

    if (isset($_POST['ask'])) {
        // Sanitize the input to prevent SQL injection
        $ask = mysqli_real_escape_string($conn, $_POST['ask']);

        $askID = $userUniqueID . $uniqueID = uniqid('', true) . "new_ask";

        // Perform your database operation here, e.g., adding the person to the database
        $q = "INSERT INTO asks (userUniqueID, ask, time, askID)  values ('$userUniqueID','$ask','" . time() . "', '$askID') ";

        if (mysqli_query($conn, $q)) {
            $success = true;
            $message = "".$askID;
        } else {
            $success = false;
            $message = mysqli_error($conn);
        }



        // Assuming $success is a boolean indicating whether the person was successfully added
        // Example value

        // Prepare JSON response
        $response = array('success' => $success, 'message' => $message);
        echo json_encode($response);
    } else {
        // found_id parameter is missing
        http_response_code(400); // Bad request
        echo json_encode(array('error' => 'found_id parameter is missing'));
    }
} else {
    // Not a POST request
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Only POST requests are allowed'));
}
