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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
        $(document).ready(function () {
            $('#example2').DataTable();
        });
    </script>
    <title>Lịch sử báo cáo niên luận</title>
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
                        <span class="title">Niên luận học kỳ</span>
                    </a>
                </li>

                <li>
                    <a href="gv_detai_hientai.php">
                        <span class="icon">
                            <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Đề tài</span>
                    </a>
                </li>
                <li>
                    <a href="gv_lichsu.php">
                        <span class="icon">
                            <ion-icon name="today-outline"></ion-icon>
                        </span>
                        <span class="title">Lịch sử báo cáo</span>
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
                        <h2>Lịch sử báo cáo</h2>
                        <div class="button-box">
                            <div id ="btn1"></div>
                            <a href="gv_lichsu.php">
                                <button type ="button" class="toggle-btn1" >Lịch sử</button>
                            </a>
                            <a href="gv_detai_toanbo.php">
                                <button type ="button" class="toggle-btn2">Đề tài các năm</button>
                            </a>
                        </div>
                    </div>
                    <table id="example"  style="width:100%">
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
                                $sql = "SELECT maTK,ngay_bao_cao,nd_thuc_hien,nd_sap_toi,thoi_han 
                                        FROM baocao JOIN dangky_detai ON dangky_detai.ID = dangky_detai_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN taikhoan ON taikhoan.ID = taikhoan_ID
                                        JOIN detai ON detai.ID = detai_ID
                                        WHERE";
                                if((isset($_SESSION['bangdt_ID']))){
                                    $bangdt_ID = $_SESSION['bangdt_ID'];
                                    $sql = $sql . " bangdt_ID = '$bangdt_ID' AND";
                                    unset($_SESSION['bangdt_ID']);
                                }
                                if(isset($_POST['timkiem'])){
                                    $timkiem = addslashes($_POST['timkiem']);
                                    $sql = $sql . " dangky_detai.taikhoan_ID = '$timkiem' AND";
                                }
                                $sql = $sql. " phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' 
                                        ORDER BY ngay_bao_cao DESC";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row["maTK"]; ?></td>
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
                    <form action="gv_lichsu.php" method="POST">
                        <table id="example2"  style="width:100%">
                            <thead>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td>Đề tài</td>
                                    <td>Năm học</td>
                                    <td>Học kỳ</td>
                                    <td>Xem</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ho_ten, tenTK, tenDT, dangky_detai.taikhoan_ID,dangky_detai.nam_hoc,dangky_detai.hoc_ky
                                FROM taikhoan JOIN  dangky_detai ON taikhoan.ID = taikhoan_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        JOIN trangthai ON trangthai_ID = trangthai.ID
                                        WHERE phutrach_ID = '$taikhoan_ID'";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php 
                                        if($row['ho_ten']== ''){
                                            echo $row['tenTK'];
                                        }
                                        else echo $row['ho_ten'];
                                    ?></td>
                                    <td><?php echo $row["tenDT"]; ?></td>
                                    <td><?php echo $row["nam_hoc"]; ?></td>
                                    <td><?php echo $row["hoc_ky"]; ?></td>
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