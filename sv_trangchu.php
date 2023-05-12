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
    </script>
    <title>Trang chủ</title>
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
                        <h2>Lịch sử báo cáo</h2>
                        <?php
                            $sql="SELECT tenDT FROM dangky_detai JOIN bangdt ON bangdt_ID = bangdt.ID
                                JOIN detai_loaidetai ON detai_loaidetai.ID = detai_loaidetai_ID
                                JOIN detai ON detai_ID = detai.ID 
                                WHERE taikhoan_ID = '$taikhoan_ID' AND dangky_detai.nam_hoc = '$nam' AND dangky_detai.hoc_ky = '$hocky'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $count = mysqli_num_rows($result);
                            if($count != 0){
                                echo '<a class="detai"><h2>'. $row["tenDT"].'</h2></a>';
                            }
                        ?>
                    </div>
                    <table id="example"  style="width:100%">
                        <thead>
                            <tr>
                                <td>Ngày báo cáo</td>
                                <td>Nội dung đã thực hiện</td>
                                <td>Nội dung công việc tiếp theo</td>
                                <td>Thời hạn thực hiện</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql ="SELECT ngay_bao_cao,nd_thuc_hien,nd_sap_toi,thoi_han FROM 
                                        baocao JOIN dangky_detai ON dangky_detai_ID =  dangky_detai.ID
                                        WHERE taikhoan_ID = '$taikhoan_ID' and nam_hoc ='$nam' and hoc_ky = '$hocky'";
                                $result = mysqli_query($conn, $sql);
                                while( $row = mysqli_fetch_assoc($result)){    
                            ?>
                            <tr>
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
                        <h2>Thang điểm</h2>
                        <?php
                            $sql = "SELECT ten_trang_thai
                            FROM trangthai JOIN dangky_detai ON trangthai_ID = trangthai.ID
                            WHERE taikhoan_ID = '$taikhoan_ID' and nam_hoc ='$nam' and hoc_ky = '$hocky'";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($result);
                            if($count != 0){
                                $row = mysqli_fetch_assoc($result);
                                if($row['ten_trang_thai'] == 'Đề xuất'){
                                    echo '<span class="status wait">Đề xuất</span>';
                                }
                                else if($row['ten_trang_thai'] == 'Thực hiện'){
                                    echo '<span class="status process">Thực hiện</span>';
                                }
                                else if($row['ten_trang_thai'] == 'Hoàn thành'){
                                    echo '<span class="status finish">Hoàn thành</span>';
                                }
                                else if($row['ten_trang_thai'] == 'Chờ duyệt'){
                                    echo '<span class="status request">Chờ duyệt</span>';
                                }
                            }
                        ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Điểm thành phần</td>
                                <td>Trọng số</td>
                                <td>Quy định</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Điểm chuyên cần</td>
                                <td>1</td>
                                <td>Mỗi lần điền báo cáo (đúng tiến độ) vào bảng bên trên sẽ được 0.2</td>
                            </tr>
                            <tr>
                                <td>Điểm quyển báo cáo</td>
                                <td>4</td>
                                <td>Quyển báo cáo: nội dung phù hợp, bố cục đúng qui định. Trình bày báo cáo.</td>
                            </tr>
                            <tr>
                                <td>Điểm chương trình</td>
                                <td>5</td>
                                <td>Đúng theo bản thiết kế, phù hợp với đề tài. Ý tưởng mới, có tính sáng tạo</td>
                            </tr>
                            <tr>
                                <td>Tổng</td>
                                <td>10</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
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