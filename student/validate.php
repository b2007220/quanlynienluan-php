<?php
 if(!isset($_SESSION['taikhoan_ID'])){
    header('location:dangnhap.php');
}
if($_SESSION['vai_tro'] == 2){
    header('location:gv_nlcoso.php');
}
if($_SESSION['vai_tro'] == 0){
    header('location:ad_ql_tk.php');
}
?>
