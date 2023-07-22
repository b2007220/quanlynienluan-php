<?php
  if(!isset($_SESSION['taikhoan_ID'])){
    header('location:dangnhap.php');
}
if($_SESSION['vai_tro'] == 1){
    header('location:sv_trangchu.php');
}
if($_SESSION['vai_tro'] == 2){
    header('location:gv_nlcoso.php');
}
?>