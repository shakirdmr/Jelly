<?php

function givetime($date)
{  
    date_default_timezone_set("Asia/Kolkata");
    $t1 = time();
    $t2 = $date;

    $sec = $t1 - $t2;
    $min = floor($sec / 60);
    $hr = floor($min / 60);
    $day = floor($hr / 24);
    $week = floor($day / 7);
    
    $value = NULL;
    
    if ($sec >= 0 && $sec < 30) {
        $value = "just now";
    } elseif ($sec >= 30 && $sec < 60) {
        $value = "$sec s";
    } elseif ($min >= 1 && $min < 60) {
        $value = "$min m";
    } elseif ($hr >= 1 && $hr < 24) {
        $value = "$hr h";
    } elseif ($day >= 1 && $day < 7) {
        $value = ($day == 1) ? "1 day" : "$day days ";
    } elseif ($week >= 1) {
        $value = ($week == 1) ? "1 week" : "$week weeks ";
    } else {
        // For any other cases, display the date in a specific format
        $value = date("d M Y", $date);
    }
    
    return $value;
}


?>