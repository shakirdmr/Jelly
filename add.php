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


        <div class="add">
        <h2 class="mt-2"> Add </h2> (Replies will be secret)

        <h6 class="mt-4">Your identity will not be secret </h6>
            <a href="addAsk">
                <div class="addItem">
                    <!-- <button> -->
                    <i class="bi bi-pencil-square"></i>
                    <div>

                        Add new Ask <br />(Question, Confession, tbh ...)
                    </div>
                    <!-- </button> -->
                </div>
            </a>


            <div class="addItem">
                <!-- <button> -->

                <i class="bi bi-arrow-up-right-circle-fill"></i>
                <div>
                    Add new Poll
                </div>
                <!-- </button> -->
            </div>



            
        <h6 class="mt-5">Your identity will be secret  </h6>
            <div class="addItem">

                <!-- <button> -->

                <i class="bi bi-arrow-up-right-circle-fill"></i>

                <!-- <i class="bi bi-incognito"></i> -->
                <div>

                    Upload Secret Posts
                </div>

                <!-- </button> -->
            </div>


        </div>


</body>

</html>