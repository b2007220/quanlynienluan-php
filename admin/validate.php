<?php
  if(!isset($_SESSION['taikhoan_ID'])){
    header('location:../login.php');
}
if($_SESSION['vai_tro'] == 1){
    header('location:./student/main.php');
}
if($_SESSION['vai_tro'] == 2){
    header('location:./teacher/main.php');
}
?>