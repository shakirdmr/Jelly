<style>
    .historyData {
        /* background: linear-gradient(-300deg, rgba(0, 0, 255, 0.555), rgba(255, 255, 0, 0.416)); */
        background: linear-gradient(-300deg, rgba(0, 0, 255, 0.155), rgba(255, 255, 0, 0.116));
        /* text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); */
        border: 0;
        /* color: white; */
        border-radius: 5px;
        width: 100%;
        padding: 10px;
        font-size: 22px;
        color: black;
        /* border: 1px solid #e9e9e9; */
    }

    .historyData  a{
        color: black;
    }

</style>
<?php


$q_history = "select * from asks where userUniqueID='$userUniqueID' ORDER BY time DESC";
$qry_history = mysqli_query($conn, $q_history);

$tol_history = mysqli_num_rows($qry_history);
if ($tol_history == 0) {
    echo "Nothing found yet add some things (show a button to add and take to add page)";
} else {


    for ($i = 0; $i < $tol_history; $i++) {

        $arr_history = mysqli_fetch_array($qry_history);
        $id =   $arr_history["askID"];

        echo " <div class='historyData'> <a href='viewAsk.php?id=$id'>" .$arr_history["ask"]
            . "</a></h4>  ";

            echo "<input class='mt-3 answerBox' type='text' placeholder='reply secretly'/> ";

            echo "<div  class='subHistoryData' style='font-size:12px'>" . $arr_history["replies"] . " replies </div>";

            echo "<div style='font-size:10px'>".givetime($arr_history["time"]) . "</div>
        
        </div> ";
    }
}

?>