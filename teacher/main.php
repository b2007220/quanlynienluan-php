<?php
    session_start();
    include('./validate.php');
    include('../time.php');
    include('../conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
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
    <title>Trang chủ niên luận cơ sở</title>
</head>

<body>
    <?php 
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 
        $sql = "SELECT ID FROM loaidetai WHERE ten_loai = 'Niên luận cơ sở'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $loai_de_tai_id = $row['ID'];

        if(isset($_POST['hoanthanh'])){
            $sinhvien_ID = $_POST['hoanthanh'];
            $sql = "SELECT ID FROM trangthai WHERE ten_trang_thai = 'Thực hiện'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $TH_ID = $row['ID'];
            $sql = "SELECT trangthai_ID FROM dangky_detai WHERE taikhoan_ID = $sinhvien_ID AND nam_hoc = $nam AND hoc_ky = $hocky";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $trang_thai_HT = $row['trangthai_ID'];
            if($trang_thai_HT == $TH_ID){
                $sql = "SELECT ID FROM trangthai WHERE ten_trang_thai = 'Hoàn thành'";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $HT_ID = $row['ID'];
                $sql = "UPDATE dangky_detai SET trangthai_ID = '$HT_ID' WHERE taikhoan_ID = $sinhvien_ID AND nam_hoc = $nam AND hoc_ky = $hocky";
                $result = mysqli_query($conn,$sql);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Đánh dấu hoàn thành thành công!',
                  })</script>"; 
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đề tài hiện đang được duyệt hoặc đã hoàn thành!',
                  })</script>"; 
            }
        }
    ?>
    <div class="container">
        <?php
        include('./navigation.php')
        ?>
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
                        <h2>Tiến độ báo cáo</h2>
                        <div class="button-box">
                            <div id ="btn1"></div>
                            <a href="main.php">
                                <button type ="button" class="toggle-btn1" >Niên luận cơ sở</button>
                            </a>
                            <a href="sub_main.php">
                                <button type ="button" class="toggle-btn2">Niên luận ngành</button>
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
                                $sql = "SELECT dangky_detai.taikhoan_ID,ngay_bao_cao,nd_thuc_hien,nd_sap_toi,thoi_han, maTK
                                        FROM baocao JOIN dangky_detai ON dangky_detai.ID = dangky_detai_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN taikhoan ON taikhoan_ID = taikhoan.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        WHERE";
                                if(isset($_POST['timkiem'])){
                                    $timkiem = addslashes($_POST['timkiem']);
                                    $sql = $sql . " dangky_detai.taikhoan_ID = '$timkiem' AND";
                                }
                                $sql = $sql. " phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' AND loaidetai_ID = $loai_de_tai_id
                                        ORDER BY ngay_bao_cao DESC
                                        LIMIT 15";
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
                    <form action="main.php" method="POST">
                        <table id = "example2"  style="width:100%">
                            <thead>
                                <tr>
                                    <td>Họ tên</td>
                                    <td>Đề tài</td>
                                    <td>Trạng thái</td>
                                    <td>Thao tác</td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ho_ten, tenDT, dangky_detai.taikhoan_ID, ten_trang_thai,tenTK,maTK
                                FROM taikhoan JOIN  dangky_detai ON taikhoan.ID = taikhoan_ID
                                        JOIN bangdt ON bangdt_ID = bangdt.ID
                                        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
                                        JOIN detai ON detai.ID = detai_ID
                                        JOIN trangthai ON trangthai_ID = trangthai.ID
                                        WHERE phutrach_ID = '$taikhoan_ID' AND bangdt.nam_hoc = '$nam' AND  bangdt.hoc_ky = '$hocky' AND dangky_detai.nam_hoc = '$nam' AND  dangky_detai.hoc_ky = '$hocky'AND loaidetai_ID = $loai_de_tai_id";
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
                                    <td><?php                                 
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
                                    ?></td>
                                    <td><button class="btn" name="timkiem" value="<?php echo $row["taikhoan_ID"]; ?>">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </button>
                                    <button class="btn" name="hoanthanh" value="<?php echo $row["taikhoan_ID"]; ?>">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
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