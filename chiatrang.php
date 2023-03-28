<!-- 
<?php
    if($trang_hien_tai > 1 ){
        $trang_truoc = $trang_hien_tai - 1; 
?>
<a href="?per_page=<?= $detai_moi_trang ?>&page=<?= $trang_hien_tai ?>" class= "minus">-</a>  
<?php    }?>
<a href="" class= "num">01</a> 
<?php
    if($trang_hien_tai < $tong_trang - 1 ){
        $trang_truoc = $trang_hien_tai + 1; 
?>
<a href="?per_page=<?= $detai_moi_trang ?>&page=<?= $trang_hien_tai ?>" class= "plus">+</a>  
<?php    }?>
                  -->


                  <div class="wrapper">
                            <?php
                            include './chiatrang.php';
                            ?>
                        </div>