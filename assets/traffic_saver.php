<?php
require("db.php");

// SAVING TRAFFIC --
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

if (filter_var($client, FILTER_VALIDATE_IP))
	$ip = $client;
else if (filter_var($forward, FILTER_VALIDATE_IP))
	$ip = $forward;
else
	$ip = $remote;

$current_page  = addslashes($_SERVER["PHP_SELF"]);
$user_ip = $ip;
$date = time();

if (isset($_COOKIE["userUniqueID"]))
	$userUniqueID = $_COOKIE["userUniqueID"];
else $userUniqueID = "NULL";

// Detect the platform and echo the result
$platform = detectPlatform();

 $q = "insert into traffic (platform, user_ip, date,userUniqueID,current_page ) values ('$platform','$user_ip','$date','$userUniqueID','$current_page')";
$qr = mysqli_query($conn, $q);


// Check for errors
if (!$qr) {
    // If there's an error, echo it
    echo "Error: " . mysqli_error($conn);
} else {
    // If the query was successful, you can optionally echo a success message
   
}





// Function to detect the user agent platform
function detectPlatform() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $platform = 'Unknown';
    
    // Check for Android
    if (strpos($userAgent, 'Android') !== false) {
        $platform = 'Android';
    }
    // Check for iOS
    elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
        $platform = 'iOS';
    }
    // Check for Mac
    elseif (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS X') !== false) {
        $platform = 'Mac';
    }
    // Check for Windows
    elseif (strpos($userAgent, 'Windows') !== false) {
        $platform = 'Windows';
    }
    
    return $platform;
}

?>
