<?php
// Include Configuration File
require('config.php');
require('assets/traffic_saver.php');

$login_button = '';

if (!isset($_COOKIE['userUniqueID'])) {
    $login_button = '<a href="' . $google_client->createAuthUrl() . '">
          <button type="button" class="login-with-google-btn" >
        Continue with Google Account
        </button></a>';}
 else
    header("location:home.php?message=already_logged_in");


if (isset($_GET["code"])) {
    $token = @$google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = @new Google_Service_Oauth2($google_client);
        $data = @$google_service->userinfo->get();

        // Check if indexes exist before accessing them
        $given_name = '';
        if (!empty($data['given_name'])) {
            $given_name = $data['given_name'];
        }

        $family_name = '';
        if (!empty($data['family_name'])) {
            $family_name = $data['family_name'];
        }

        $email = '';
        if (!empty($data['email'])) {
            $email = $data['email'];
        }

        $gender = '';
        if (!empty($data['gender'])) {
            $gender = $data['gender'];
        }

        $picture = '';
        if (!empty($data['picture'])) {
            $picture = $data['picture'];
        }

        $uniqueID = uniqid('', true) . '_' ;

        if (!already_registered_user($email)) {
            // SET INTO DB, MAKE COOKIES,  AND REDIRECT TO HOME PAGE
            insertIntoDB($uniqueID, $given_name, $family_name, $email, $gender, $picture);
            makeACookie($uniqueID);
        }
        header("location:home.php?welcome_to_the_app");
    } else {
        echo "ERROR " . $token['error'];
    }
}

require("components/includeAllHTML_CSS_FILES.php");


?>


<body>

    <?php
    require("components/header.php");

    if (isset($_SESSION["warning"])) {
        echo "<div style='background-color:red; padding:5px; display:flex; justify-content:center'>  ";
        echo $_SESSION["warning"];
        echo "</div>";
    }
    ?>

    <div class="loginBody">



        <div style="margin-top:100px">
            👋 Welcome back
        </div>
        <span class="h1 fw-bold mt-4 mb-0  ">To continue, login first</span>

        <?php


        if ($login_button == '') {
            $message =  "message= ERROR: ALREDAY LOGGED IN WITH UNIQUE ID" . $_COOKIE["userUniqueID"];
            // REDIRECT TO HOME
            header("location:home.php?$message");
        } else {

            echo '<div style="margin: 20px 0 100px 0;">
    
    ' . $login_button . '</div>';
        }
        ?>

    </div>


    <?php
    require("components/footer.php");  ?>

</body>

</html>


<?php
function already_registered_user($email)
{

    require('assets/db.php');

    // Prepare SQL statement
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $qry = mysqli_query($conn, $sql);
    $arr= mysqli_fetch_array($qry);

    var_dump($arr);

    // Check if any rows were returned
    if (mysqli_num_rows($qry) > 0) {
        // Entry exists
        mysqli_close($conn);
        makeACookie($arr["userUniqueID"]);
        return true;
    } else {
        // Entry does not exist
        mysqli_close($conn);
        return false;
    }
}

function makeACookie($cookieValue)
{
    // Set cookie expiration time to 6 months
    $expiration = time() + (6 * 30 * 24 * 60 * 60); // 6 months from now

    // Set the cookie
    setcookie('userUniqueID', $cookieValue, $expiration, '/');

    // Optionally, you can also set the cookie domain and path
    // setcookie('your_cookie_name', $cookieValue, $expiration, '/', 'yourdomain.com');
}

function insertIntoDB($uniqueID, $given_name, $family_name, $email, $gender, $picture)
{
    require('assets/db.php');

    $query = "INSERT INTO users (userUniqueID,first_name, last_name, email, gender, picture, created) VALUES ('$uniqueID','$given_name', '$family_name', '$email', '$gender', '$picture', '".time()."')";

    mysqli_query($conn, $query);
    // Check for errors if needed
    if (mysqli_errno($conn)) {
        echo "Error: " . mysqli_error($conn);
    }
}

?>