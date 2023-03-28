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
    <title>Trang chủ niên luận ngành</title>
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
                        <h2>Lịch sử báo cáo</h2>
                        <a class="detai" href='#' onclick="window.location.reload(true);"><h2>Niên luận ngành</h2></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>MSSV</td>
                                <td>Ngày báo cáo</td>
                                <td>Nội dung đã thực hiện</td>
                                <td>Nội dung công việc tiếp theo</td>
                                <td>Thời hạn thực hiện</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT dangky_detai.taikhoan_ID,ngay_bao_cao,nd_thuc_hien,nd_sap_toi,thoi_han 
                                        FROM baocao JOIN dangky_detai ON dangky_detai.ID = dangky_detai_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        WHERE";
                                if(isset($_POST['timkiem'])){
                                    $timkiem = addslashes($_POST['timkiem']);
                                    $sql = $sql . " dangky_detai.taikhoan_ID = '$timkiem' AND";
                                }
                                $sql = $sql. " phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' AND loaidetai_ID = 'loai0002'
                                        ORDER BY ngay_bao_cao DESC
                                        LIMIT 15";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row["taikhoan_ID"]; ?></td>
                                <td><?php echo $row["ngay_bao_cao"]; ?></td>
                                <td><?php echo $row["nd_thuc_hien"]; ?></td>
                                <td><?php echo $row["nd_sap_toi"]; ?></td>
                                <td><?php echo $row["thoi_han"]; ?></td>
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Học sinh phụ trách</h2>
                    </div>
                    <form action="gv_nlnganh.php" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td>Đề tài</td>
                                    <td>Xem</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ho_ten, tenDT, dangky_detai.taikhoan_ID
                                FROM taikhoan JOIN  dangky_detai ON taikhoan.ID = taikhoan_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        WHERE phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' AND loaidetai_ID = 'loai0002'";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["ho_ten"]; ?></td>
                                    <td><?php echo $row["tenDT"]; ?></td>
                                    <td><button class="btn" name="timkiem" value="<?php echo $row["taikhoan_ID"]; ?>">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </button></td>
                                </tr>
                                <?php }
                            ?>
                            </tbody>
                        </table>
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