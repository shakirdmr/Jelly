<?php

// Include Configuration File
$userUniqueID = $_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');


require("components/includeAllHTML_CSS_FILES.php");
echo "<br>";
require("components/homeFooter.php");
require("trueBackend/time.php");



if (!isset($_GET["id"]))
    die("NO ID SET");
else
    $askID = $_GET["id"];



// $q = "SELECT * FROM following WHERE follower = '$userUniqueID'";
$q = "SELECT asks.*, users.* from asks INNER JOIN users on asks.userUniqueID = users.userUniqueID 
WHERE asks.askID = '$askID'";

$query = mysqli_query($conn, $q);
$tol = mysqli_num_rows($query);


if ($tol == 0) {
    $nothing_found_in_search = 1;
    die("NOTHING FOUND AS THE GIVEN ID ---");
}
// ELSE



$arr = mysqli_fetch_array($query);
// var_dump($arr);       

$ask = $arr["ask"];
$userUniqueID = $arr["userUniqueID"];
$replies = $arr["replies"];
$time = $arr["time"];
$picture = $arr["picture"];
$name = $arr["first_name"] . " " . $arr["last_name"];

$found_id_ask = $arr["askID"];

echo "<div class='homePageAskCard'>
        <a href='./profile?user=" . $userUniqueID . "'>
            <div style='display:inline-flex; align-items:center'>
                <img class='profilePicture' src='" . $picture . "'>  
                <div style='margin-left:5px'>" . $name . "</div>
            </div>
        </a> 
        <div class='anAsk'>" . $ask . "</div>";


// If-else
echo "<div style='display:flex'>
        <input maxlength='100' class='answerBox' style='padding-right:30px' type='text' placeholder='reply secretly' id=" . $found_id_ask . "/> 
        <button style='margin-left:-60px; border:0; background:0;' onclick='addReply(\"$found_id_ask\")'> 
            <i class='bi bi-node-plus-fill' style='font-size:18px; color:#a1a1a1'></i>
        </button>
    </div>";

echo "<div class='subHistoryData' style='font-size:12px'>" . $replies . " replies </div>";

echo "<div class='time'>" . givetime($time) . "</div>
      </div>";









      
echo "<div class='replies' style='margin:15px'> 
<h3>Replies </h3>";


//NOW CHECK REPLIES
$q = "SELECT askReplies.*, users.first_name from askReplies
INNER JOIN users on askReplies.userUniqueID_replier = users.userUniqueID 
      WHERE askID = '$askID' ORDER BY time DESC";

$query = mysqli_query($conn, $q);
$tol = mysqli_num_rows($query);



if ($tol == 0) {
    echo "<h6 style='margin:20px; text-align:center'>No replies Yet, be the first to reply secretly from above </h6>";
    $nothing_found_in_search = 1;
} else {

    $usersFoundData = array();
    for ($i = 0; $i < $tol; $i++) {

        $arr = mysqli_fetch_array($query);
        // var_dump($arr);       

         $userUniqueID_replier = $arr["first_name"];
        
        $first_digit_of_repliers_name = substr($userUniqueID_replier, 0, 1);;

        //LATER ON IMPLEMENT ABOVE FEATURE TO PAID USERS

        $askReply = $arr["askReply"];
        $time = giveTime($arr["time"]);

        echo " <div style='border-bottom:1px solid #f1f1f1; padding:10px 0 0 10px; '>

        <div  style='display:flex; font-size:12px; align-items:center; justify-content:center; background-color:#f1f1f1; width:15px; height:15px; border-radius:20%; color:#a5a5a5'>$first_digit_of_repliers_name </div>

        <div style='display:flex;align-items:center; margin:5px 0 0 0px'>
        <h3 style='color:#5a5a5a'>$askReply  </h3>
                    <i style='font-size: 12px;'>$time</i> </div>
                    </div>";
    }
}


echo "</div>";

?>


<script>
    function addReply(askID) {

        // AJAX request
        var askReply = document.querySelector(`input[id="${askID}/"]`).value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'trueBackend/addAskReply.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Callback function when the AJAX request completes
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful, handle response
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Reply added successfully");

                    document.querySelector(`input[id="${askID}/"]`).value = "";
                    // Optionally, you can perform additional actions here, like updating the UI
                } else {
                    alert('Failed to add reply.');
                }
            } else {
                // Request failed
                alert('Failed to send AJAX request.');
            }
        };

        // Send the AJAX request with the post's ID and reply content
        var params = 'askID=' + encodeURIComponent(askID) + '&askReply=' + encodeURIComponent(askReply);
        xhr.send(params);
    }
</script>
</body>


</html>