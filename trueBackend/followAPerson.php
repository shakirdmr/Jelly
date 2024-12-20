<?php

$userUniqueID = @$_COOKIE["userUniqueID"];
// Assuming $conn is your database connection

require("../assets/db.php");
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the found_id parameter exists in the POST request

    if (isset($_POST['found_id'])) {
        // Sanitize the input to prevent SQL injection
        $found_id = mysqli_real_escape_string($conn, $_POST['found_id']);

        // Perform your database operation here, e.g., adding the person to the database
        $q = "SELECT * FROM following
        WHERE following='$found_id' AND follower='$userUniqueID'
         ";

        $query = mysqli_query($conn, $q);


        $tol = mysqli_num_rows($query);
        if ($tol == 0) {
            //SITUATION where a follow happens bcz thers nothing already in table 

            // SQL query to insert data
            $sql = "INSERT INTO following (follower, following) VALUES ('$userUniqueID', '$found_id')";

            // Execute query
            if (mysqli_query($conn, $sql)) {

                $q = "SELECT first_name, last_name, picture FROM users
                WHERE userUniqueID='$userUniqueID'
                ";
                $query = mysqli_query($conn, $q);
                $arr = mysqli_fetch_array($query);

                $picture = $arr["picture"];
                


                // Escape special characters in the message
                echo $message_to_user = "<a href='./profile?user=$userUniqueID'>" ."
                <div style='display:flex; align-items:center'>
                
                <div>
                <img src='$picture' width=40px style='border-radius:100%; margin-right:10px'> </div>

                <div>
                ". htmlspecialchars($arr["first_name"]) . " " . htmlspecialchars($arr["last_name"]) . " started following you
                </div>


                </div>
                
                </a>";


                $message_to_user = mysqli_real_escape_string($conn, $message_to_user);

                $time = time();

                $q = "INSERT INTO notifications (userUniqueID, type, message, time) VALUES ('$found_id', 'follow', '$message_to_user', '$time')";

                // Execute the query using mysqli_query() as you did in your previous examples

                if (!mysqli_query($conn, $q)) {
                    $success = false;
                    $message = mysqli_error($conn);
                } else {

                    $q = "UPDATE users SET following = following+1 WHERE userUniqueID = '$userUniqueID'";

                    if (!mysqli_query($conn, $q)) {
                        $success = false;
                        $message = mysqli_error($conn);
                    } else {

                        $q = "UPDATE users SET followers = followers+1 WHERE userUniqueID = '$found_id'";

                        if (!mysqli_query($conn, $q)) {
                            $success = false;
                            $message = mysqli_error($conn);
                        } else {

                            $success = true;
                            $message = "Following";
                        }
                    }
                }
            } else {
                $success = false;
                $message = mysqli_error($conn);
            }
        } else {
            //THIS IS THE SITUATION WHERE UNFOLLOW HAPPENS

            // SQL query to delete data
            $sql = "DELETE FROM following WHERE follower = '$userUniqueID' AND  following = '$found_id'";

            // Execute query
            if (mysqli_query($conn, $sql)) {

                $q = "UPDATE users SET following = following-1 WHERE userUniqueID = '$userUniqueID'";
                if (!mysqli_query($conn, $q)) {
                    $success = false;
                    $message = mysqli_error($conn);
                } else {

                    $q = "UPDATE users SET followers = followers-1 WHERE userUniqueID = '$found_id'";
                    if (!mysqli_query($conn, $q)) {
                        $success = false;
                        $message = mysqli_error($conn);
                    } else {

                        $success = true;
                        $message = "Follow";
                    }
                }
            } else {
                $success = false;
                $message = mysqli_error($conn);
            }
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
