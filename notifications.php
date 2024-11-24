<style> 
.notification a{
    color: black;

}
</style>

<?php
$userUniqueID = $_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
require("components/homeFooter.php");

            require("assets/db.php");
            require("trueBackend/time.php");
?>

<body style="margin-bottom: 100px;">



    <div class="mainContent">

        <div style="position:relative; width:100%; display:flex">

            <h2>Notifications</h2>
        </div>    

            <?php

            // require("components/header.php");
            

            if (isset($_GET["user"])) {
                if ($userUniqueID == $_GET["user"])
                    $sameUserUsingAsWhoToFind = 1;

                $userUniqueID = $_GET["user"];
            }


            $q = "select *  from notifications  where userUniqueID='$userUniqueID' AND notificationRead=0";

            $query = mysqli_query($conn, $q);

            $tol = mysqli_num_rows($query);
            if ($tol == 0) {
                $nothing_found_in_search = 1;
            } else {

                for ($i = 0; $i < $tol; $i++) {

                    $arr = mysqli_fetch_array($query);

                    $msg =  $arr["message"];
                    $picture = $arr["profile"];
                    $time = givetime($arr["time"]);

                    echo " <div class='notification' style='display:flex; align-items:center'>

                    
                    $msg  
                   
                    
                    </div>";

                    // $name = $arr["first_name"] . " " . $arr["last_name"];

                }
            }
            ?>

    </div>


</body>

</html>