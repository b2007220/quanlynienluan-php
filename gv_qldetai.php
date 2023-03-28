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
    <title>Đề tài giáo viên</title>
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
        $taikhoan = $_SESSION['taikhoan'];    
        $sql = "SELECT mgv FROM thongtingv WHERE matk = '$matk'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $mgv = $row['mgv'];

        $date = getdate();
        $month = $date['month'];
        $year = $date['year'];
        if($month >= 1 && $month <=5){
            $hocki = 2;
        }
        else if($month >= 6  && $month <=7){
            $hocki = 3;
        }
        else $hocki = 1;
    ?>
    <?php
        if(isset($_POST['them'])){
            $madt = addslashes($_POST['them']);
            $sql = "SELECT madt FROM sudung WHERE mgv = '$mgv' AND hocki = '$hocki' AND nam = '$year' AND madt = '$madt'"; 
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            if($count > 0){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đề tài đã được sử dụng!',
                  })</script>";
            }
            else{
                $sql = "INSERT INTO sudung VALUES ('$madt','$mgv',$year,$hocki)";
                $result = mysqli_query($conn, $sql);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Đã thêm đề tài vào năm nay!',
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
                        <span class="title">Giảng viên</span>
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
                        $sql = "SELECT ho_ten, gioitinh_id,tenTK FROM taikhoan WHERE ID = '$taikhoan_ID'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $loichao = "Chào ";
                        if($row['ho_ten'] != ''){
                            if($row['gioitinh_id'] == 2){
                                $loichao = $loichao . "thầy ";
                            }
                            else if($row['gioitinh_id'] == 3){
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
                        <h2>Bảng đề tài</h2>
                    </div>
                    <form action="gv_qldetai.php" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td>Tên</td>
                                    <td>Hình thức</td>
                                    <td>Năm</td>
                                    <td>Học kì</td>
                                    <td>Sử dụng lại</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ten,hinhthuc,nam,hocki,d.madt FROM sudung s join detai d on s.madt = d.madt
                                        WHERE `mgv` = '$mgv' ";
                                if(isset($_POST['timkiem'])){
                                    if(($_POST['ten']) !=''){
                                        $ten = addslashes($_POST['ten'] );
                                        $sql = $sql . " AND ten = '$ten'";
                                    }
                                    if(($_POST['hinhthuc'])!= ''){
                                        $hinhthuc = addslashes($_POST['hinhthuc']);
                                        if($hinhthuc == "Hè"){
                                            $hinhthuc = 3;
                                        }
                                        $sql = $sql . " AND hinhthuc = '$hinhthuc'";
                                    }
                                    if(($_POST['nam'])!=''){
                                        $nam = addslashes($_POST['nam']);
                                        $sql = $sql . "AND nam = '$nam'";
                                    }
                                    if(($_POST['hocki'])!=''){
                                        $hocki = addslashes($_POST['hocki']);
                                        $sql = $sql . " AND hocki = '$hocki'";
                                    }
                                }
                                $sql = $sql. "ORDER BY NAM  DESC,HOCKI DESC,HINHTHUC DESC";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["ten"]; ?></td>
                                    <td><?php 
                                switch ($row["hinhthuc"]) {
                                    case "1":
                                      echo "Niên luân cơ sở";
                                      break;
                                    case "2":
                                      echo "Niên luận ngành";
                                      break;
                                    case "3":
                                      echo "Cả hai";
                                      break; 
                                }?>
                                    </td>
                                    <td><?php echo $row["nam"]; ?></td>
                                    <td><?php echo $row["hocki"]; ?></td>
                                    <td><button class="btn" name="them" value="<?php echo $row["madt"]; ?>">
                                        <ion-icon name="checkmark-outline"></ion-icon>
                                        </button></td>
                                </tr>
                                <?php }
                            ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Bảng tìm kiếm</h2>
                    </div>
                    <form action="gv_qldetai.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                            <span>Lọc theo tên</span>
                            <input list="dsdetai" name="ten" autocomplete="off" />
                                <datalist id="dsdetai">
                                    <?php
                                $sql ="SELECT DISTINCT ten FROM sudung s join detai d on s.madt = d.madt WHERE mgv = '$mgv'";
                                $result = mysqli_query($conn, $sql);
                                while( $row = mysqli_fetch_assoc($result)){    
                                ?>
                                    <option value="<?php echo $row["ten"]; ?>">
                                        <?php }
                               ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                            <span>Lọc theo hình thức</span>
                            <input list="dshinhthuc" name="hinhthuc"
                                    autocomplete="off" />
                                <datalist id="dshinhthuc">
                                    <option value="Niên luận cơ sở">
                                    <option value="Niên luận ngành">
                                    <option value="Cả hai">
                                </datalist>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                            <span>Lọc theo năm</span>
                            <input list="dsnam" name="nam" autocomplete="off" />
                                <datalist id="dsnam">
                                    <?php
                                $sql ="SELECT DISTINCT nam FROM sudung s join detai d on s.madt = d.madt WHERE mgv = '$mgv'";
                                $result = mysqli_query($conn, $sql);
                                while( $row = mysqli_fetch_assoc($result)){    
                                ?>
                                    <option value="<?php echo $row["nam"]; ?>">
                                        <?php }
                               ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                            <span>Lọc theo học kì</span>
                            <input list="dshocki" name="hocki"
                                    autocomplete="off" />
                                <datalist id="dshocki">
                                    <option value="1">
                                    <option value="2">
                                    <option value="Hè">
                                </datalist>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="timkiem" value="Tìm kiếm">
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