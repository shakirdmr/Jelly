<?php
$userUniqueID = @$_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<style>
    input {
        padding: 10px;
        width: 100%;
        border: 0;

        /* border: 1px solid #f1f1f1; */
    }
</style>

<body>

    <?php

    require("components/homeFooter.php");
    require("assets/db.php");

    if(isset($_POST["shareQuestionOnJellyAndOtherPlatforms"]))
    {
        echo $ask = $_POST["ask"];
    }


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

                $name = $arr["first_name"];
                $found_id =  $arr['userUniqueID'];

                if (isset($arr['picture']))
                    $photo = $arr['picture'];
                else $photo = "assets/graphics/deafultImage.png";

                $userData = array(
                    "name" => $name,
                    "found_id" => $found_id,
                    "photo" => $photo
                );

                // Add the user's data array to the main array
                $usersFoundData[] = $userData;

                $qry = mysqli_query($conn, $q);
                $arr = mysqli_fetch_array($qry);
            }
        }
    }

    ?>

    <div class="mainContent">

        <form  method=POST>
        <h2> Add Ask </h2>

        <div class="addBox">
            <h6> Add your Question that other people can answer. You won't know who they are (anonymous).
        </div>
        
            <input class="questionBox" type="text" placeholder="Type here" style="width: 100%;" id="questionBox" name="ask"/>


        <button type="button" style="width:100%" class="mt-3" 
        onclick='shareAsk()'
        name="shareQuestionOnJellyAndOtherPlatforms">
        Share
        </button>
</form>


    </div>



    <script>
        window.onload = function() {
            var placeholders = [
                "Describe me in 3 words!",
                "What u like in me?",
                "Should I goto school tommorow?"
            ];

            // Function to update placeholder
            function updatePlaceholder() {
                var now = new Date();
                var index = now.getSeconds() % placeholders.length;
                document.getElementById("questionBox").setAttribute("placeholder", placeholders[index]);
            }

            // Update placeholder initially
            updatePlaceholder();

            // Update placeholder every second
            setInterval(updatePlaceholder, 2000);
        };


        
            function shareAsk() {
                // AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'trueBackend/shareAsk.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                // Callback function when the AJAX request completes
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {

                        // Request was successful, handle response
                        var response = JSON.parse(xhr.responseText);
                        //console.log(response);

                        if (response.success) {

                            alert("Successfully shared it. Now show instagram facebook snapchat whatsapp sahre options with a LINK and when done redirect to the home or that posts feed  \n\n\n\n"+response.message);
                        } else {
                            alert('Failed .'+response.message);
                        }
                    } else {
                        // Request failed
                        alert('Failed to send AJAX request.');
                    }
                };

                // Send the AJAX request with the person's ID
                var params = 'ask=' + document.getElementById('questionBox').value;
                xhr.send(params);
            }
        

    </script>
</body>

</html>