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
 $activePage = basename($_SERVER['PHP_SELF']); // Gets the current file name


// Function to determine the active icon class
function isActive($page, $currentPage)
{
    return $page == $currentPage;
}


?>

<div class="homeFooter">
    <div class="homeFooterIcons">
        <a href="home.php">
        
            <i class="<?php echo isActive('home.php', $activePage) ? 'bi-house-door-fill' : 'bi-house-door'; ?>"></i>
        </a>


        <a href="search">
            <i class="<?php echo isActive('search.php', $activePage) ? 'bi bi-search-heart-fill' :'bi-search'; ?>"></i>
        </a>

        <a href="add">
            <i class="<?php echo isActive('add.php', $activePage)  ||  isActive('addAsk.php', $activePage)?' bi-plus-square-fill':'bi-plus-square'; ?>"></i>
        </a>

        <a href="notifications">
            <div class='notification'>
                <i style="display: flex;" class="<?php echo isActive('notifications.php', $activePage) ? 'bi bi-bell-fill':'bi bi-bell'; ?>"> </i>
                
                <?php if ($totalNotifications != 0) echo "<div class='notificationBox'>" . $totalNotifications . " </div>"; ?>
            </div>
        </a>

        <a href="profile">
            <i class="<?php echo isActive('profile.php', $activePage) && !isset($_GET["user"]) ? 'bi bi-person-fill' :'bi bi-person'; ?>"></i>
        </a>
    </div>
</div>