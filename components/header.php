

<!-- <a href="../private/css/header.css">ds</a> -->
<div class='header' style="margin:10px 0 0 0; padding:10px">
    <a class="home_logo" href="./home">

        <img src="./assets/graphics/app-logo.png" alt="app logo" width="50px" />
        
        <div style="margin-left: 10px; font-size:30px; font-weight:5px; color:black">
            Jelly
    </div>
    </a>


    <?php

    if (isset($_COOKIE["userUniqueID"])) {
        echo '    <i class="bi bi-chat-dots"></i>';
        echo '<i class="bi bi-list"></i>';
    }


    ?>

</div>