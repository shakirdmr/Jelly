<?php

session_start();

var_dump($_SESSION);

require("db.php");
require("traffic_saver.php");
require("components/includeAllHTML_CSS_FILES.php");

?>

<body style="margin: 0 25% 0 25%">


<?php
    require("components/header.php");
    
    if (isset($_SESSION["warning"])) {
        echo "<div style='background-color:red; padding:5px; display:flex; justify-content:center'>  ";
        echo $_SESSION["warning"];
        echo "</div>";
    }


    ?>

    <div style="margin-top:20px">
        👋 Welcome back
    </div>
    <span class="h1 fw-bold mb-0  ">To continue login first</span>



    <?php
    require("components/footer.php");  ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <?php session_destroy(); ?>
</body>

</html>