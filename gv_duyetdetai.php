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
    <title>Duyệt đề tài</title>
</head>
<body>
    <?php 
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
        $conn -> set_charset("utf8");
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

        if(isset($_POST['duyet'])){
            $sinhvien_ID = addslashes($_POST['duyet']);
            $sql = "SELECT ID FROM trangthai WHERE ten_trang_thai = 'Thực hiện'";
            $result = mysqli_query($conn,$sql);
            $row= mysqli_fetch_assoc($result);
            $thuc_hien_ID = $row['ID'];
            $sql = "UPDATE dangky_detai SET trangthai_ID = '$thuc_hien_ID' WHERE taikhoan_ID = '$sinhvien_ID' AND hoc_ky = '$hocky' AND nam_hoc = '$nam'";
            $result = mysqli_query($conn,$sql);
            $sql = "SELECT detai_loaidetai_ID FROM dangky_detai 
            JOIN bangdt on bangdt.id = bangdt_ID
            WHERE taikhoan_ID = '$sinhvien_ID' AND phutrach_ID = '$taikhoan_ID' AND dangky_detai.hoc_ky = '$hocky' AND dangky_detai.nam_hoc = '$nam' 
            AND bangdt.hoc_ky = '$hocky' AND bangdt.nam_hoc = '$nam'";
            $result = mysqli_query($conn,$sql);
            $row= mysqli_fetch_assoc($result);
            $detai_loaidetai_ID = $row['detai_loaidetai_ID']; 
            $sql = "UPDATE detai_loaidetai SET chinhthuc = 1 WHERE ID = '$detai_loaidetai_ID'";
            $result = mysqli_query($conn,$sql);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Duyệt đề tài thành công!',
              })</script>";  
        }
        
        if(isset($_POST['huy'])){
            $sinhvien_ID = addslashes($_POST['huy']);
            $sql = "SELECT detai_loaidetai_ID FROM dangky_detai 
            JOIN bangdt on bangdt.id = bangdt_ID
            WHERE taikhoan_ID = '$sinhvien_ID' AND phutrach_ID = '$taikhoan_ID' AND dangky_detai.hoc_ky = '$hocky' AND dangky_detai.nam_hoc = '$nam' 
            AND bangdt.hoc_ky = '$hocky' AND bangdt.nam_hoc = '$nam'";
            $result = mysqli_query($conn,$sql);
            $row= mysqli_fetch_assoc($result);
            $detai_loaidetai_ID = $row['detai_loaidetai_ID'];
            $sql = "SELECT chinhthuc, detai_ID FROM detai_loaidetai WHERE ID = '$detai_loaidetai_ID'";
            $result = mysqli_query($conn,$sql);
            $row= mysqli_fetch_assoc($result);
            if($row['chinhthuc'] == 0){
                $detai_ID = $row['detai_ID'];
                $sql = "DELETE FROM detai WHERE ID = '$detai_ID'";
                $result = mysqli_query($conn,$sql);
            }
            else{
                $sql = "DELETE FROM dangky_detai WHERE taikhoan_ID = '$sinhvien_ID' AND hoc_ky = '$hocky' AND nam_hoc = '$nam'";
                $result = mysqli_query($conn,$sql);
            }
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Đã từ chối duyệt đề tài!',
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
            <div class="detail">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Duyệt đề tài</h2>
                        <div class="button-box">
                            <div id ="btn2"></div>
                            <a href="gv_detai_hientai.php">
                                <button type ="button" class="toggle-btn2" >Năm nay</button>
                            </a>
                            <a href="gv_duyetdetai.php">
                                <button type ="button" class="toggle-btn1">Duyệt đề tài</button>
                            </a>
                        </div>
                    </div>
                    <form action="gv_duyetdetai.php" method="POST">
                    <table id = "example"  style="width:100%">
                            <thead>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td>Đề tài</td>
                                    <td>Mô tả đề tài</td>
                                    <td>Trạng thái</td>
                                    <td>Duyệt đề tài</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ho_ten, tenDT,mo_taDT, dangky_detai.taikhoan_ID, ten_trang_thai,tenTK
                                FROM taikhoan JOIN  dangky_detai ON taikhoan.ID = taikhoan_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        JOIN trangthai ON trangthai_ID = trangthai.ID
                                        WHERE (ten_trang_thai = 'Đề xuất' OR ten_trang_thai = 'Chờ duyệt') AND
                                        phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' AND dangky_detai.nam_hoc = '$nam' AND  dangky_detai.hoc_ky = '$hocky'";
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
                                    <td><?php echo $row["mo_taDT"]; ?></td>
                                    <td><?php                                 
                                        if($row['ten_trang_thai'] == 'Đề xuất'){
                                            echo '<span class="status wait">Đề xuất</span>';
                                        }
                                        else if($row['ten_trang_thai'] == 'Chờ duyệt'){
                                            echo '<span class="status request">Chờ duyệt</span>';
                                        }                                
                                    ?></td>
                                    <td><button class="btn" name="duyet" value="<?php echo $row["taikhoan_ID"]; ?>">
                                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        </button>
                                        <button class="btn" name="huy" value="<?php echo $row["taikhoan_ID"]; ?>">
                                            <ion-icon name="close-outline"></ion-icon>
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