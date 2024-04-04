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
require("components/homeFooter.php");
require("trueBackend/time.php");


// $q = "SELECT * FROM following WHERE follower = '$userUniqueID'";
$q = "SELECT following.*, users.picture, users.first_name, users.last_name FROM following 
      INNER JOIN users ON following.following = users.userUniqueID 
      WHERE following.follower = '$userUniqueID'";


$query = mysqli_query($conn, $q);
$tol = mysqli_num_rows($query);

echo "<hr>";

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
                "ask" => $post["ask"],
                "time" => $post["time"],
                "picture" => $arr["picture"],
                "name" => $arr["first_name"] . " ". $arr["last_name"] 
            );

            // Add the post's data array to the main array
            $posts[] = $postData;
        }
    }


    // var_dump($posts);

    // Sort posts by time order
    usort($posts, function ($a, $b) {
        // print_r( $a);
        return $b['time'] - $a['time'];
    });



    // Display posts on the home page
    foreach ($posts as $post) {

        if ($post['picture'] == "")
            $post['picture'] = "./assets/graphics/app-logo.png";

        echo "<div class='homePageAskCard'>

        <div class='userInfo'>

            <a href='./profile?user=" . $post['userUniqueID'] . "'>
            <div style='display:flex; align-items:center'>
            <img class='profilePicture' src='" . $post['picture'] . "'>  
            <div style='margin-left:5px'>
            " . $post["name"] .
            "</div> </div> </div></a> 

        <div class='anAsk'>"
            . $post['ask'] . "</div>";

        // if - else
        // echo "<input style='answerBox' type='text'/>";

        echo "
        <div class='time'> " . givetime($post['time']) . " </div>
      </div>";
    }
}


?>


</body>

</html>