<?php
$userUniqueID = @$_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<style>
    input {
        padding: 10px;
        width: 100%;
        border-radius: 20px;
        border: 1px solid #f1f1f1;
    }
</style>

<body>

    <?php

    require("components/homeFooter.php");
    require("assets/db.php");

    if (isset($_GET["query"])) {
        $query = $_GET["query"];

        $q = "SELECT * FROM users WHERE
        (email LIKE '%$query%' OR first_name LIKE '%$query%' OR last_name LIKE '%$query%') 
        AND ( userUniqueID NOT LIKE '%$userUniqueID%')
    ";
        $query = mysqli_query($conn, $q);

        $tol = mysqli_num_rows($query);
        if ($tol == 0) {
            $nothing_found_in_search = 1;
        } else {

            $usersFoundData = array();
            for ($i = 0; $i < $tol; $i++) {

                $arr = mysqli_fetch_array($query);

                $name = $arr["first_name"] . " ".$arr["last_name"];
                $found_id =  $arr['userUniqueID'];

                if (isset($arr['picture']))
                    $photo = $arr['picture'];
                else $photo = "assets/graphics/profile.png";

                $userData = array(
                    "name" => $name,
                    "found_id" => $found_id,
                    "photo" => $photo
                );

                // Add the user's data array to the main array
                $usersFoundData[] = $userData;
            }
        }
    }

    ?>

    <div class="mainContent">

        <div style="width:100%;position: relative; display: flex;">

            <form id="searchForm" style="display: flex; flex-grow: 1;">
                <input type="text" name="query" id="searchInput" placeholder="Search friend name or email" style="width: 100%;" <?php
                                                                                                                                if (isset($_GET["query"]))
                                                                                                                                ?>>

                <button type="submit" style="position: absolute; right: 0; top: 0; bottom: 0; border: 0; background: 0;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>


      

        <div class="searchItemsContainer">

            <?php

        if (isset($usersFoundData)) {

            // Loop through the $usersFoundData array
            foreach ($usersFoundData as $userData) {
                // Access individual user data
                $name = $userData["name"];
                $found_id = $userData["found_id"];

                $photo = $userData["photo"];

                //CHECK IF I FOLLOW THAT PERSON OR NOT
                $q = "SELECT * FROM following WHERE following='$found_id' AND follower='$userUniqueID' ";

                $query = mysqli_query($conn, $q);

                $follow_unfollow_message = "NULL";
                $tol = mysqli_num_rows($query);
                if ($tol != 0)
                    $follow_unfollow_message = "Following";
                else
                    $follow_unfollow_message = "Follow";

                echo "
                    <div class='searchItem'>
                    
                    <div>
                    <img src=$photo alt='user image'  
                    class='roundedImage'/>
                    </div>
                    
                    <div>
                    $name <br>
                    
                    <button 
                    style='" . ($follow_unfollow_message == 'Follow' ? "background-color: blue; color: white;" : "") . "' 
                
                     id=$found_id onclick='followAPerson(\"$found_id\")'> $follow_unfollow_message </button>

                    <button> Chat </button>
                    </div>
                    
                    </div>
                    ";
                // Now you can use $name, $found_id, and $photo as needed
                // echo "Name: $name, Found ID: $found_id, Photo: $photo <br><br><br>";
            }
        }

            ?>
        </div>


        <script>
            function followAPerson(found_id) {
                // AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'trueBackend/followAPerson.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                // Callback function when the AJAX request completes
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {

                        // Request was successful, handle response
                        var response = JSON.parse(xhr.responseText);
                        // console.log(response);

                        if (response.success) {
                            var button = document.getElementById(found_id);
                            button.innerHTML = response.message;
                        } else {
                            alert('Failed to add person to the database.');
                        }
                    } else {
                        // Request failed
                        alert('Failed to send AJAX request.');
                    }
                };

                // Send the AJAX request with the person's ID
                var params = 'found_id=' + encodeURIComponent(found_id);
                xhr.send(params);
            }
        </script>


</body>

</html>