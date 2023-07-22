<?php
    if(isset($_SESSION['taikhoan_ID'])){
        if($_SESSION['vai_tro'] == 1 ){
            header('location:./student/main.php');
        }
        else if($_SESSION['vai_tro'] == 2){
            header('location:./teacher/main.php');
        }
        else if($_SESSION['vai_tro'] == 0){
            header('location:./admin/main.php');
        }
    }
?>