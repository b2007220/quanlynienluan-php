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
    <title>Thông tin sinh viên</title>
</head>

<body>
    <?php 
         $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
         $conn -> set_charset("utf8");
         $taikhoan_ID = $_SESSION['taikhoan_ID']; 
 
 
         if(!isset($_SESSION['taikhoan_ID'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['vai_tro'] == 2){
            header('location:gv_nlcoso.php');
        }
        if($_SESSION['vai_tro'] == 0){
            header('location:ad_ql_tk.php');
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
        if(isset($_POST['capnhat'])){        
            $hoten = addslashes($_POST['hoten']);
            $nganh = addslashes($_POST['nganh']);
            $khoa = addslashes($_POST['khoa']);
            $mssv = addslashes($_POST['mssv']);
            $gioitinh = addslashes($_POST['gioitinh']);
            $sql4 = "UPDATE taikhoan SET ho_ten = '$hoten', chuyennganh_ID = '$nganh', khoa = '$khoa', gioitinh_ID = '$gioitinh', maTK = '$mssv'  WHERE ID= '$taikhoan_ID'";
            $result4 = mysqli_query($conn, $sql4);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Cập nhật thông tin thành công!',
              })</script>";
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
            <!-- detail list-->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Thông tin cá nhân</h2>
                    </div>
                    <form action="sv_thongtin.php" method="POST">
                        <?php
                            $sql = "SELECT ho_ten,tenTK,chuyennganh_ID,gioitinh_ID,maTK,khoa FROM taikhoan JOIN chuyennganh ON chuyennganh_ID = chuyennganh.ID
                            WHERE taikhoan.ID = '$taikhoan_ID'";
                            $result = mysqli_query($conn, $sql);
                            $row2 = mysqli_fetch_assoc($result);
                            if($row2['khoa'] == 0){
                                $row2['khoa'] = 42;
                            }
                        ?>
                        <div class="row50">
                            <div class="input-box">
                                <span>Họ tên</span>
                                <input type="text" value="<?php echo $row2['ho_ten'];?>" name="hoten" autocomplete="off" required>
                            </div>
                            <div class="input-box">
                                <span>Ngành học</span>
                                <select name = "nganh">
                                    <?php
                                    $sql ="SELECT ID,tenCN FROM chuyennganh";
                                    $result = mysqli_query($conn, $sql);
                                    while( $row = mysqli_fetch_assoc($result)){
                                        if($row['ID'] == $row2['chuyennganh_ID']){
                                            echo '<option value="'.$row['ID'].'" selected>'. $row['tenCN'] .'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$row['ID'].'">'. $row['tenCN'] .'</option>';
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="input-box">
                                <span>Email</span>
                                <input type="email" name="email" readonly value="<?php echo $row2['tenTK'];?>" required></input>
                            </div>
                            <div class="input-box">
                                <span>MSSV</span>
                                <input type="text" name="mssv" value="<?php echo $row2['maTK'];?>" required autocomplete="off"></input>
                            </div>
                        </div>
                        <div class="row25">
                            <div class="input-box">
                                <span>Khóa</span>
                                <input type="number" min="42" name="khoa" value="<?php echo $row2['khoa'];?>" required></input>
                            </div>                     
                        </div>
                        <div class="row25">
                            <div class="input-box">
                                <span>Giới tính</span>
                                <select name="gioitinh">
                                <?php
                                    $sql ="SELECT ID,tenGT FROM gioitinh";
                                    $result = mysqli_query($conn, $sql);
                                    while( $row = mysqli_fetch_assoc($result)){
                                        if($row['ID'] == $row2['gioitinh_ID']){
                                            echo '<option value="'.$row['ID'].'" selected>'. $row['tenGT'] .'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$row['ID'].'">'. $row['tenGT'] .'</option>';
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="capnhat" value="Cập nhật">
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