<?php
     $today = date("Y-m-d");
    $new_date = date('Y-m-d', strtotime($today. ' + 2 weeks'));
    $month = date("m");
    $nam =  date("Y");
    if($month >= 1 && $month <=5){
        $hocky = 2;
    }
    else if($month >= 6  && $month <=7){
        $hocky = 3;
    }
    else $hocky = 1;
?>