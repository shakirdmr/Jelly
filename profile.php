<?php
$userUniqueID = $_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<body style="margin-bottom: 100px;">

    <?php

    // require("components/header.php");
    require("components/homeFooter.php");
    require("assets/db.php");
    require("trueBackend/time.php");

    if (isset($_GET["user"])) {
        if ($userUniqueID == $_GET["user"])
            $sameUserUsingAsWhoToFind = 1;

        $userUniqueID = $_GET["user"];
    }


    $q = "select * from users where userUniqueID='$userUniqueID'";
    $qry = mysqli_query($conn, $q);
    $arr = mysqli_fetch_array($qry);




    if (isset($arr['picture']))
        $photo = $arr['picture'];
    else $photo = "assets/graphics/profile.png";

    // $p_id = $arr['username'] ;
    $profile_email  = $arr['email'];
    $followers  = $arr['followers'];
    $asks  = $arr['asks'];
    $polls  = $arr['polls'];
    $following  = $arr['following'];
    $gender  = $arr['gender'];
    // $password = $arr['password'];
    $name = $arr['first_name'] . " " . $arr['last_name'];

    $date = $arr['created'];
    // $verify = $arr['verify'];
    ?>

    <div class="mainContent">

        <div style="position:relative; width:100%; display:flex">

            <h2>Profile</h2>

            <?php
            if (isset($_GET["user"]) && isset($sameUserUsingAsWhoToFind)) {
                echo "<i class='bi bi-gear-wide-connected' style='position:absolute; right:0'></i>";
            } elseif (!isset($_GET["user"])) {
                echo "<i class='bi bi-gear-wide-connected' style='position:absolute; right:0'></i>";
            }
            ?>


        </div>

        <div class="mainProfile" style="position:relative; width:100%">

        <div class="containerProfile" style="width: 80px; overflow:hidden; height:80px; 
        border-radius:100%;display:flex; align-items:center; justify-content:center; ">

            <img src="shakir.jpg"
            style="border-radius:100%; width:90%;
            height:90%" />
            
        </div>
            <?php
            if (isset($_GET["user"])) {
                if (isset($sameUserUsingAsWhoToFind))
                    echo "
            <a href='editProfile.php'>
                <button class='editProfile'> Edit Profile </button></a> ";
            } else
                echo "
            <a href='editProfile.php'>
                <button class='editProfile'> Edit Profile </button></a> ";

            ?>

        </div>

        <div class="subMainProfile" style="margin:10px 0 0 10px;">
            <h4> <?php echo $name ?></h4>


            <!-- <div style="margin-top: 20px; display:flex" class="row">

                <?php echo $asks; ?> Polls

                <?php echo $polls; ?> Asks

            </div> -->


            <div style="display: flex; font-size:16px; font-weight:bold">

           
                <div>
                <?php echo $followers; ?> Followers 
        </div>

                <div style='margin-left:10px'>
                <?php echo $following; ?> Following
        </div>
            </div>


            <div style="">
                Joined <?php echo $date ?>
            </div>
        </div>

        <h2 style="margin-top: 10px;"> History </h2>

        <?php include("trueBackend/historyOFMyData.php");  ?>
    </div>


</body>

</html>