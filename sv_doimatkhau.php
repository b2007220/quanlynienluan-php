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
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
    
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 
    
    
        if(!isset($_SESSION['taikhoan_ID'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['vai_tro'] == 2){
            header('location:gv_nlcoso.php');
        }
        if($_SESSION['vai_tro'] == 0){
            header('location:ad_ql_gv.php');
        }
        $month = date("m");
        $nam =  date("Y");
        if($month >= 1 && $month <=5){
            $hocky = 2;
        }
        else if($month >= 6  && $month <=7){
            $hocky = 3;
        }
        else $hocky = 1;
        
        if(isset($_POST['doi'])){
            $sql = "SELECT matkhau FROM taikhoan where ID = '$taikhoan_ID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            $mkcu = md5(addslashes($_POST['mkcu']));
            $mkmoi = addslashes($_POST['mkmoi']);
            $mkxn = addslashes($_POST['mkxn']);

            if(strcmp($row['matkhau'],$mkcu) == 0){
                if($mkmoi == $mkxn){
                    $mkxn = md5($mkxn);
                    $sql = "UPDATE taikhoan SET mat_khau = '$mkxn' WHERE ID = '$taikhoan_ID'";
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
                            <ion-icon name="school-outline"></ion-icon>
                        </span>
                        <span class="title">Sinh viên</span>
                    </a>
                </li>
                <li>
                    <a href="sv_trangchu.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="sv_thongtin.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Thông tin</span>
                    </a>
                </li>
                <li>
                    <a href="sv_detai.php">
                        <span class="icon">
                            <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Đề tài</span>
                    </a>
                </li>

                <li>
                    <a href="sv_baocaotiendo.php">
                        <span class="icon">
                            <ion-icon name="reader-outline"></ion-icon>
                        </span>
                        <span class="title">Báo cáo tiến độ</span>
                    </a>
                </li>
                <li>
                    <a href="sv_doimatkhau.php">
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
                        $sql = "SELECT tenTK,ho_ten FROM taikhoan  WHERE ID = '$taikhoan_ID'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        if(!empty($row['ho_ten'])){
                                echo '<h2>'.'Chào bạn '.$row['ho_ten'].'</h2>';
                            }
                        else{
                                echo '<h2>'.'Chào bạn '.$row['tenTK'].'</h2>';
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