<style> 
.notificationBox{
  width: 18px;
  height: 18px;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 100%;
  background-color: red;
  font-size: 10px;
  margin: -10px 0px 0px -20px;
}</style>

<?php
// Include Configuration File
$userUniqueID = $_COOKIE["userUniqueID"];

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

// Determine active page
echo $activePage = basename($_SERVER['PHP_SELF']); // Gets the current file name


// Function to determine the active icon class
function isActive($page, $currentPage) {
    echo "HIIIIII";
    return ($page == $currentPage) ? 'bi' : '';
}

function isActivee(){
    return "f";
}

echo isActivee();

?>

<div class="homeFooter">
    <div class="homeFooterIcons">
        <a href="home">
            <i class="<?php echo isActive('home.php', $activePage); ?> bi-house-door"></i>
        </a>

        <a href="search">
            <i class="<?php echo isActive('search.php', $activePage); ?> bi-search"></i>
        </a>

        <a href="add">
            <i class="<?php echo isActive('add.php', $activePage); ?> bi-plus-square"></i>
        </a>

        <a href="bell">
            <div class='notification'>
                <i class="<?php echo isActive('bell.php', $activePage); ?> bi bi-bell" style="display: flex;"></i>
                <?php if($totalNotifications !=0) echo "<div class='notificationBox'>".$totalNotifications." </div>"; ?>
            </div>
        </a>

        <a href="profile">
            <i class="<?php echo isActive('profile.php', $activePage); ?> bi bi-person"></i>
        </a>
    </div>
</div>
