    <?php

    // // Set cookie expiration time to 6 months
    $expiration = time() + (6 * 30 * 24 * 60 * 60); // 6 months from now

    // // Set the cookie
    //  setcookie('userUniqueID', "65ffeb88396e69.61375746_Shakir", $expiration, '/');

    // Include Configuration File
    $userUniqueID = $_COOKIE["userUniqueID"];

    require('config.php');
    require('assets/traffic_saver.php');


    require("components/includeAllHTML_CSS_FILES.php");
    require("components/header.php");
    echo "<br>";
    require("components/homeFooter.php");
    require("trueBackend/time.php");


    // $q = "SELECT * FROM following WHERE follower = '$userUniqueID'";
    $q = "SELECT following.*, users.picture, users.first_name, users.last_name FROM following 
        INNER JOIN users ON following.following = users.userUniqueID 
        WHERE following.follower = '$userUniqueID'";


    $query = mysqli_query($conn, $q);
    $tol = mysqli_num_rows($query);


    if ($tol == 0) {
        $nothing_found_in_search = 1;
    } else {

        $usersFoundData = array();
        for ($i = 0; $i < $tol; $i++) {

            $arr = mysqli_fetch_array($query);
            // var_dump($arr);       
            $following = $arr["following"];

            // Fetch posts made by each user
            $q_posts = "SELECT * FROM asks WHERE userUniqueID = '$following' ORDER BY time DESC LIMIT 10";
            $query_posts = mysqli_query($conn, $q_posts);

            // Store posts data
            while ($post = mysqli_fetch_assoc($query_posts)) {
                $postData = array(
                    "userUniqueID" => $post["userUniqueID"],

                    "askID" => $post["askID"],
                    "ask" => $post["ask"],
                    "replies" => $post["replies"],
                    "time" => $post["time"],
                    "picture" => $arr["picture"],
                    "name" => $arr["first_name"] . " " . $arr["last_name"]
                );



                // Add the post's data array to the main array
                $posts[] = $postData;

                // var_dump($posts);
            }
        }
    }




    //GET MY OWN DATA ALSO

    // Fetch posts made by each user
    $q_posts = "SELECT asks.*, users.picture, users.first_name, users.last_name  
            FROM asks 
            INNER JOIN users ON asks.userUniqueID = users.userUniqueID 
            WHERE asks.userUniqueID = '$userUniqueID'
            ORDER BY asks.time DESC 
            LIMIT 10";

    $query_posts = mysqli_query($conn, $q_posts);
    // Store posts data
    while ($post = mysqli_fetch_assoc($query_posts)) {

        // var_dump($post);
        $postData = array(
            "userUniqueID" => $post["userUniqueID"],
            "ask" => $post["ask"],
            "askID" => $post["askID"],
            "replies" => $post["replies"],
            "time" => $post["time"],
            "picture" => $post["picture"],
            "name" => $post["first_name"] . " " . $post["last_name"]
        );
        // Add the post's data array to the main array
        // echo $postData["ask"];
        $posts[] = $postData;
    }
    //GET MY OWN DATA ALSO




    if (isset($posts)) {

        // Sort posts by time order
        usort($posts, function ($a, $b) {
            // print_r( $a);
            return $b['time'] - $a['time'];
        });
        // Display posts on the home page
        foreach ($posts as $post) {
            // var_dump($post);
            echo "<div class='homePageAskCard'>

            <a  href='./profile?user=" . $post['userUniqueID'] . "'>
                    <div  style='display:inline-flex; align-items:center'>

                        <img class='profilePicture' src='" . $post['picture'] . "'>  
                        <div style='margin-left:5px'>
                        " . $post["name"] .
                " </div> </div></a> 

                    <div class='anAsk'>"
                . $post['ask'] . "</div>";
            $found_id_ask = $post["askID"];

            // if - else
            echo "<div style='display:flex'>

            <input maxlength='100' class='answerBox' style='padding-right:30px'type='text' placeholder='reply secretly' id=" . $found_id_ask . "/> 

            <button style='margin-left:-60px; border:0; background:0;' 
            onclick='addReply(\"$found_id_ask\")'> 
            <i  
            class='bi bi-node-plus-fill' style='font-size:18px; color:#a1a1a1'>
            </i></button>
            </div>";

            echo "<div  class='subHistoryData' style='font-size:12px'>" . $post["replies"] . " replies </div>";

            echo "
                    <div class='time'> " . givetime($post['time']) . " </div>
                </div>";
        }
    } else {
        echo "<div class='noPostsFound'> <h2>No posts found to show you.  </h2><br><br>Follow some persons or start posting yourself (at this time we show suggestions to follow and also an Add button) </div>";
    }



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