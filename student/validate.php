<?php
 if(!isset($_SESSION['taikhoan_ID'])){
    header('location:../login.php');
}
if($_SESSION['vai_tro'] == 2){
    header('location:./teacher/main.php');
}
if($_SESSION['vai_tro'] == 0){
    header('location:./admin/main.php');
}
?>
