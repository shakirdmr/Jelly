<?php

$userUniqueID = @$_COOKIE["userUniqueID"];
// Assuming $conn is your database connection

require("../assets/db.php");
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the found_id parameter exists in the POST request

    if (isset($_POST['askReply'])) {
        // Sanitize the input to prevent SQL injection
        $askReply = mysqli_real_escape_string($conn, $_POST['askReply']);

        $askID = $_POST['askID'];
        $userUniqueID_of_replier = $userUniqueID;

        // Perform your database operation here, e.g., adding the person to the database
        $q = "INSERT INTO askReplies (userUniqueID_replier, askReply,  askID ,time)  values ('$userUniqueID_of_replier','$askReply', '$askID','" . time() . "') ";

        if (mysqli_query($conn, $q)) {


            $q = "UPDATE asks SET replies = replies+1 WHERE askID = '$askID'";
            if(!mysqli_query($conn, $q))
            {


                //CREATE A NEW NOTIFICATION

                $success = false;
                $message = mysqli_error($conn);
            } else {

                
                $success = true;
                $message = "";
            }
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
