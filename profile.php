<?php
$userUniqueID = $_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<body>

    <?php
    // require("components/header.php");
    require("components/homeFooter.php");
    require("assets/db.php");

      $q="select * from users where userUniqueID='$userUniqueID'";
		$qry= mysqli_query($conn,$q);
		$arr= mysqli_fetch_array($qry);

        


        if(isset($arr['picture']))
		$photo= $arr['picture']; 
		else $photo= "assets/graphics/profile.png";
		
		// $p_id = $arr['username'] ;
		$profile_email  = $arr['email'];
		$gender  = $arr['gender'];
		// $password = $arr['password'];
		$name = $arr['first_name']." ".$arr['last_name'];
		
		$date = $arr['created'];
		// $verify = $arr['verify'];
    ?>

<div class="mainContent">


<i class="bi bi-gear-wide-connected" style=""></i>
    <div class="mainProfile">
        <img src="<?php echo $photo ?>" width="70px" style="border-radius:100%"/>
        
        <a href="editProfile.php">
        <button class="editProfile"> Edit Profile </button></a>
    </div>
    
    <div class="subMainProfile" style="margin:10px 0 0 10px;">
        <h4> <?php echo $name ?></h4>
        <h6> <?php echo $gender ?></h6>
        <h6> <?php echo $profile_email ?></h6>


        <div style="margin-top: 20px;">
            0 Polls  
            4 Asks
        </div>

        
        <div>
            3 Followers  
            4 Following
        </div>


        <div style="margin-top: 20px;">
            Joined <?php echo $date ?>
        </div>
    </div>

    <h2 style="margin-top: 30px;"> History </h2>

    <?php include("historyOFMyData.php");  ?>
</div>

    
</body>

</html>