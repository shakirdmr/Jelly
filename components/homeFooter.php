<style>
    </style>
<?php
// Include Configuration File
 $userUniqueID = $_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");

require("assets/db.php");



 $q = "SELECT * FROM notifications WHERE userUniqueID = '$userUniqueID'";
$query = mysqli_query($conn, $q);

if (!$query) {
    // Query execution failed, handle the error
    echo "Error: " . mysqli_error($conn);
} else {
    // Query executed successfully
    $totalNotifications = mysqli_num_rows($query);
}
  


?>

<div class="homeFooter">
    <div class="homeFooterIcons">

        <a href="home">
            <i class="bi bi-house-door"></i>
        </a>

        <a href="search">
        <i class="bi bi-search"></i>
        
            </a>

        <a href="add">
            <i class="bi bi-plus-square"></i>
        </a>

        <a href="bell">

        <div class='notification'>
        <i class="bi bi-bell"> </i>

        <?php if($totalNotifications !=0) 
        echo "<div class='notificationBox'>".$totalNotifications." </div>"; ?>
         </div>
        
        </a>
        
        <a href="profile">
            <i class="bi bi-person"></i>
        </a>
    </div>
</div>
