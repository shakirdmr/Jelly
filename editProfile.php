<style>
    input {
        padding: 10px;
        width: 100%;
        border-radius: 20px;
        border: 1px solid #f1f1f1;
    }
</style>

<?php
require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<body>

    <?php
    // require("components/header.php");
    require("components/homeFooter.php");

    require("assets/db.php");

    $q = "select * from users where userUniqueID='$userUniqueID'";
    $qry = mysqli_query($conn, $q);
    $arr = mysqli_fetch_array($qry);




    if (isset($arr['picture']))
        $photo = $arr['picture'];
    else $photo = "assets/graphics/profile.png";

    // $p_id = $arr['username'] ;
    $profile_email  = $arr['email'];
    $gender  = $arr['gender'];
    // $password = $arr['password'];
    $name = $arr['first_name'] . " " . $arr['last_name'];


    ?>



    <div class="mainContent" style="padding-bottom:100px">

    
    <i class="bi bi-gear-wide-connected" style=""></i>
    
    <h2> Edit Profile </h2>

        <div class="mainProfile">
            <img src="<?php echo $photo ?>" width="70px" style="border-radius:100%" />

            <a href="editProfile.php">
                <button class="editProfile"> Change Photo </button></a>
        </div>

        Name <input type="text" value="<?php echo $name ?>" />


        Email <input type="text" value="<?php echo $profile_email ?>" disabled />

        Phone <input type="text" value="" />

        Gender
        <input type="text" value="<?php echo $gender ?>" maxlength="8" />
        <input type="submit" value="Update" />

    </div>


</body>

</html>