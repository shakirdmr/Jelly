<?php
$userUniqueID = @$_COOKIE["userUniqueID"];

require('assets/traffic_saver.php');
require("components/includeAllHTML_CSS_FILES.php");
?>

<style>
    input {
        padding: 10px;
        width: 100%;
        border-radius: 20px;
        border: 1px solid #f1f1f1;
    }
</style>

<body>

    <?php

    require("components/homeFooter.php");
    require("assets/db.php");

    ?>

    <div class="mainContent">

        <div style="width:100%;position: relative; display: flex;">

            <form id="searchForm" style="display: flex; flex-grow: 1;">
                <input type="text" name="query" id="searchInput" placeholder="Search friend name or email" style="width: 100%;">
                <button onclick="search()" type="button" style="position: absolute; right: 0; top: 0; bottom: 0; border: 0; background: 0;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>


        <div id="searchResults">
            <?php
            if (isset($_GET['response'])) {

                echo "YESSS";
                $response = json_decode($_GET['response'], true);
                // Process and display data using PHP
                foreach ($response as $item) {
                    echo '<div>';
                    echo '<p>Name: ' . $item['name'] . '</p>';
                    echo '<p>Email: ' . $item['email'] . '</p>';
                    // Add more data fields as needed
                    echo '</div>';
                }
            } else
                echo "NOOOOO";
            ?>
        </div>

    </div>




    <script>
        function search() {
            var query = document.getElementById('searchInput').value;
            $.ajax({
                url: 'fullBackend/getSearchData.php',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    // Process JSON response using JavaScript
                    var data = JSON.parse(response);
                    var html = '';
                    data.forEach(function(item) {
                        html += '<div>';
                        html += '<p>Name: ' + item.name + '</p>';
                        html += '<p>Email: ' + item.email + '</p>';
                        // Add more data fields as needed
                        html += '</div>';
                    });
                    $('#searchResults').html(html);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>