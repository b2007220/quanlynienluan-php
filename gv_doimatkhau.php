<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Đổi mật khẩu</title>
</head>
<body>
    <?php 
         if(!isset($_SESSION['taikhoan'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['loai'] == 1){
            header('location:sv_trangchu.php');
        }
        if($_SESSION['loai'] == 0){
            header('location:ad_ql_gv.php');
        }

        $conn = mysqli_connect("localhost", "root", "", "nienluan");
        $matk = $_SESSION['matk'];    
    ?>
    <?php
        if(isset($_POST['doi'])){
            $sql = "SELECT matkhau FROM taikhoan where matk = '$matk'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            $mkcu = addslashes($_POST['mkcu']);
            $mkmoi = addslashes($_POST['mkmoi']);
            $mkxn = addslashes($_POST['mkxn']);

            if($row['matkhau' == $mkcu]){
                if($mkmoi == $mkxn){
                    $sql = "UPDATE taikhoan SET matkhau = '$mkxn' WHERE matk = '$matk'";
                    $result = mysqli_query($conn, $sql);
                    echo"<script>Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Đổi mật khẩu thành công!',
                      })</script>";
                }
                else{
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Mật khẩu mới và xác nhận không khớp!',
                      })</script>";
                }
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu cũ không đúng!',
                  })</script>";
            }
        }
    ?>
    <div class="container">
        <div class="navigation">
        <ul>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="cafe-outline"></ion-icon>
                        </span>
                        <span class="title">Giáo viên</span>
                    </a>
                </li>
                <li>
                    <a href="gv_nlcoso.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>

                        </span>
                        <span class="title">Niên luận cơ sở</span>
                    </a>
                </li>
                <li>
                    <a href="gv_nlnganh.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Niên luận ngành</span>
                    </a>
                </li>
                <li>
                    <a href="gv_detai.php">
                        <span class="icon">
                            <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Đề tài</span>
                    </a>
                </li>
                <li>
                    <a href="gv_qldetai.php">
                        <span class="icon">
                            <ion-icon name="clipboard-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lí đề tài</span>
                    </a>
                </li>
                <li>
                    <a href="gv_thongtin.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Thông tin giảng viên</span>
                    </a>
                </li>
                <li>
                    <a href="gv_doimatkhau.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                            </ion-icon>
                        </span>
                        <span class="title">Đổi mật khẩu</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="exit-outline"></ion-icon>
                        </span>
                        <span class="title">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <!-- topbar -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="username">
                    <?php
                        $sql = "SELECT hotengv,gioitinh FROM thongtingv  WHERE matk= '$matk'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $loichao = "Chào ";
                        if($row['hotengv'] != ''){
                            if($row['gioitinh']== 1){
                                $loichao = $loichao . "thầy ";
                            }
                            else{
                                $loichao = $loichao . "cô ";
                            } 
                            echo '<h2>'.$loichao .$row['hotengv'].'<h2>'; 
                        }
                        else{
                            echo '<h2>'.$loichao .$taikhoan.'<h2>'; 
                        }
                    ?>
                </div>
            </div>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đổi mật khẩu</h2>
                    </div>  
                    <form action="sv_doimatkhau.php" method ="POST">
                    <div class="row50">
                            <div class="input-box">
                                <span>Mật khẩu cũ</span>
                                <input type="password" value="" name="mkcu" required>
                            </div>
                   </div>
                   <div class="row50">
                            <div class="input-box">
                                <span>Mật khẩu mới</span>
                                <input type="password" value="" name="mkmoi" required>
                            </div>
                   </div>
                   <div class="row50">
                            <div class="input-box">
                                <span>Xác nhận một khẩu mới</span>
                                <input type="password" value="" name="mkxn" required>
                            </div>
                   </div>
                   <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="doi" value="Đổi">
                            </div>
                        </div>
                </form>
                </div>    
            </div>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
    //menutoggle
    let toggle = document.querySelector('.toggle');
    let navigation = document.querySelector('.navigation');
    let main = document.querySelector('.main');

    toggle.onclick = function() {
        navigation.classList.toggle('active');
        main.classList.toggle('active');
    }
    //add hovered class in selected list item
    let list = document.querySelectorAll('.navigation li');

    function activeLink() {
        list.forEach((item) =>
            item.classList.remove('hovered'));
        this.classList.add('hovered');
    }
    list.forEach((item) =>
        item.addEventListener('mouseover', activeLink));
    </script>
</body>

</html>