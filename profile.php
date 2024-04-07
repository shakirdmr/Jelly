
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

    if(isset($_GET["user"]))
    {
        if($userUniqueID == $_GET["user"])
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

    <div class="mainContent" >

    <div style="position:relative; width:100%; display:flex">

        <h2>Profile</h2>

        <?php 
            if(isset($_GET["user"]))
            {
                if(isset($sameUserUsingAsWhoToFind))
                echo "
                <i class='bi bi-gear-wide-connected' style='position:absolute; right:0'></i> ";

            }
            else
            echo "
            <i class='bi bi-gear-wide-connected' style='position:absolute; right:0'></i> ";

                ?>
    
    </div>

        <div class="mainProfile" style="position:relative; width:100%">

            <img src="<?php echo $photo ?>" width="70px" style="border-radius:100%" />

            <?php 
            if(isset($_GET["user"]))
            {
                if(isset($sameUserUsingAsWhoToFind))
                echo "
            <a href='editProfile.php'>
                <button class='editProfile'> Edit Profile </button></a> ";

            }
            else
            echo "
            <a href='editProfile.php'>
                <button class='editProfile'> Edit Profile </button></a> ";

                ?>

        </div>

        <div class="subMainProfile" style="margin:10px 0 0 10px;">
            <h4> <?php echo $name ?></h4>
            <h6> <?php echo $gender ?></h6>
            <h6> <?php echo $profile_email ?></h6>


            <div style="margin-top: 20px; display:flex" class="row">
              
                    <?php echo $asks; ?> Polls
                
                    <?php echo $polls; ?> Asks
               
            </div>


            <div class="row">
               
                    <?php echo $followers; ?> Followers
              
                    <?php echo $following; ?> Following
            </div>


            <div style="margin-top: 10px;">
                Joined <?php echo $date ?>
            </div>
        </div>

        <h2 style="margin-top: 10px;"> History </h2>

        <?php include("trueBackend/historyOFMyData.php");  ?>
    </div>


</body>

</html>