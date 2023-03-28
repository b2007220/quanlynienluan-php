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
    <title>Thông tin giảng viên</title>
</head>

<body>
    <?php 
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
        
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 

        if(!isset($_SESSION['taikhoan_ID'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['vai_tro'] == 1){
            header('location:sv_trangchu.php');
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

        if(isset($_POST['capnhat'])){        
            $hoten = addslashes($_POST['hoten']);
            $nganh = addslashes($_POST['nganh']);
            $mgv = addslashes($_POST['mgv']);
            $gioitinh = addslashes($_POST['gioitinh']);
            if($gioitinh == 'Nam'){
                $gioitinh = 1;
            }
            else if($gioitinh == 'Nữ'){
                $gioitinh = 2; 
            }
            $sql3 = "SELECT ID FROM chuyennganh WHERE tenCN = '$nganh'";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);
            $manganh = $row3['ID'];

            $sql4 = "UPDATE taikhoan SET ho_ten = '$hoten', chuyennganh_ID = '$manganh', gioi_tinh = '$gioitinh', maTK = '$mgv'  WHERE ID= '$taikhoan_ID'";
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
                        $sql = "SELECT ho_ten, gioi_tinh,tenTK FROM taikhoan WHERE ID = '$taikhoan_ID'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $loichao = "Chào ";
                        if($row['ho_ten'] != ''){
                            if($row['gioi_tinh'] == 1){
                                $loichao = $loichao . "thầy ";
                            }
                            else if($row['gioi_tinh'] == 2){
                                $loichao = $loichao . "cô ";
                            } 
                            echo '<h2>'.$loichao .$row['ho_ten'].'<h2>'; 
                        }
                        else{
                            echo '<h2>'.$loichao .$row['tenTK'].'<h2>'; 
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
                    <form action="gv_thongtin.php" method="POST">
                    <?php
                            $sql = "SELECT ho_ten,tenTK,tenCN,gioi_tinh,maTK,khoa FROM taikhoan JOIN chuyennganh on chuyennganh_ID = chuyennganh.ID
                            WHERE taikhoan.ID = '$taikhoan_ID'";
                            $result = mysqli_query($conn, $sql);
                            $row2 = mysqli_fetch_assoc($result);
                            if($row2['khoa'] == 0){
                                $row2['khoa'] = 42;
                            }
                            if($row2['gioi_tinh'] == 1){
                                $gioitinh = 'Nam';
                            }
                            else if(['gioi_tinh'] == 2){
                                $gioitinh = 'Nữ';
                            }
                            else{
                                $gioitinh = '';
                            }
                        ?>
                        <div class="row50">
                            <div class="input-box">
                                <span>Họ tên</span>
                                <input type="text" value="<?php echo $row2['ho_ten'];?>" name="hoten" autocomplete="off" required>
                            </div>
                            <div class="input-box">
                                <span>Chuyên ngành</span>
                                <input list="dsnganh" name="nganh" value="<?php echo $row2['tenCN'];?>" autocomplete="off" required />
                                <datalist id="dsnganh">
                                    <?php
                                    $sql ="SELECT tenCN FROM chuyennganh";
                                    $result = mysqli_query($conn, $sql);
                                    while( $row = mysqli_fetch_assoc($result)){    
                                    ?>
                                    <option value="<?php echo $row["tenCN"];?>">
                                        <?php }
                                ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="input-box">
                                <span>Email</span>
                                <input type="email" name="email" readonly value="<?php echo $row2['tenTK'];?>" required></input>
                            </div>
                            <div class="input-box">
                                <span>MGV</span>
                                <input type="text" name="mgv" value="<?php echo $row2['maTK'];?>" required autocomplete="off"></input>
                            </div>
                        </div>
                        <div class="row25">
                            <div class="input-box">
                                <span>Giới tính</span>
                                <input list="dsdetai" name="gioitinh" value="<?php echo $gioitinh;?>" required  />
                                <datalist id="dsdetai">
                                    <option value="Nam">
                                    <option value="Nữ">
                                </datalist> 
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