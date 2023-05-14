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
    <title>Đề tài sinh viên</title>
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
        $sql = "SELECT chuyennganh_ID FROM TAIKHOAN WHERE ID = $taikhoan_ID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $chuyennganh_ID = $row['chuyennganh_ID'];
        $sql = "SELECT ID FROM loaidetai WHERE ten_loai = 'Niên luận cơ sở'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $nlcs_ID = $row['ID'];
        $sql = "SELECT ID FROM loaidetai WHERE ten_loai = 'Niên luận ngành'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $nln_ID = $row['ID'];

        $hinhthuc = '';
        $phutrach_ID ='';

        $sql = "SELECT ID FROM trangthai WHERE ten_trang_thai = 'Đề xuất'";
        $result = mysqli_query($conn,$sql);
        $row_id = mysqli_fetch_array($result);
        $de_xuat_id= $row_id['ID'];

        $sql = "SELECT ID FROM trangthai WHERE ten_trang_thai = 'Chờ duyệt'";
        $result = mysqli_query($conn,$sql);
        $row_id = mysqli_fetch_array($result);
        $cho_duyet_id= $row_id['ID'];

        //tìm id giảng viên và hình thức
        $sql1 = "SELECT phutrach_ID, loaidetai_ID,bangdt.ID
        FROM bangdt JOIN dangky_detai ON bangdt_ID = bangdt.ID
        JOIN detai_loaidetai ON detai_loaidetai_ID = detai_loaidetai.ID
        WHERE taikhoan_ID = '$taikhoan_ID' and dangky_detai.nam_hoc = '$nam' and dangky_detai.hoc_ky = '$hocky'";
        $result1 = mysqli_query($conn, $sql1);    
        $count1 = mysqli_num_rows($result1);
        if($count1 != 0){
            $row1 = mysqli_fetch_array($result1);
            $phutrach_ID = $row1['phutrach_ID'];
            $hinhthuc = $row1['loaidetai_ID'];
            $sql2 = "SELECT ho_ten
            FROM taikhoan
            WHERE ID = '$phutrach_ID'";
            $result2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($result2);
            if($count2 == 0){
                $gv='';
            }
            else{
                $row2 = mysqli_fetch_assoc($result2);
                $gv = $row2['ho_ten'];
            }
        }
        else{
            $gv='';
        }
        //đăng kí giảng viên và hình thức
        if(isset($_POST['xacnhan'])){
            if($count1 == 0 ){
                if(isset($_POST['type'])){
                    $gv = addslashes($_POST['gv']);
                    $hinhthuc = addslashes($_POST['type']);
                    $_SESSION['hinhthuc'] = $hinhthuc;
                    $_SESSION['phutrach_ID'] = $gv;
                }
                else{
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng đăng kí hình thức niên luận!',
                    })</script>";
                }
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Bạn đã đăng kí đề tài năm nay!',
                })</script>";
            }
        }

        if(isset($_POST['dangki'])){
            if(isset($_SESSION['phutrach_ID'])){
                $phutrach_ID = $_SESSION['phutrach_ID'];
                $bangdt_ID = addslashes($_POST['bangdt_ID']);
                if($bangdt_ID != 0){
                    if($count1 == 0){
                        $sql6 = "INSERT INTO dangky_detai(taikhoan_ID, bangdt_ID, trangthai_Id, hoc_ky, nam_hoc)  VALUES ('$taikhoan_ID', '$bangdt_ID', '$cho_duyet_id' ,'$hocky','$nam')";
                        $result6 = mysqli_query($conn,$sql6);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Đăng ký đề tài thành công!',
                            confirmButtonText: 'Xác nhận',
                            })</script>";
                    }
                    else{
                        $sql5 = "UPDATE dangky_detai SET bangdt_ID = '$bangdt_ID', trangthai_ID = $cho_duyet_id  WHERE taikhoan_ID = '$taikhoan_ID' AND nam_hoc = '$nam' AND hoc_ky = '$hocky'";
                        $result5 = mysqli_query($conn,$sql5);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Chỉnh sửa đề tài thành công!',
                            confirmButtonText: 'Xác nhận',
                            })</script>"; 
                    }
                }
                else{
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng chọn đề tài!',
                    })</script>";
                }
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Chưa đăng kí giảng viên!',
                })</script>";
            }
        }
        if(isset($_POST['dexuat'])){  
            if(isset($_SESSION['phutrach_ID'])){
                $ten_dexuat = addslashes($_POST['dtmoi']);
                $mota_dexuat = addslashes($_POST['mota_dexuat']);
                $phutrach_ID = $_SESSION['phutrach_ID'];
                $hinhthuc = $_SESSION['hinhthuc'];
    
                $sql6 = "INSERT INTO detai(tenDT, mo_taDT) VALUES ('$ten_dexuat','$mota_dexuat')";
                $result6 = mysqli_query($conn,$sql6);
                $sql6_id = "SELECT ID FROM detai WHERE tenDT='$ten_dexuat' AND mo_taDT='$mota_dexuat'";
                $result6_id = mysqli_query($conn,$sql6_id);
                $row6_id = mysqli_fetch_array($result6_id);
                $de_tai_id =$row6_id['ID'];
    
                $sql7 = "INSERT INTO detai_loaidetai(detai_ID,loaidetai_ID,chinhthuc) VALUES ($de_tai_id, $hinhthuc,0)";
                $result7 = mysqli_query($conn,$sql7);
                $sql7_id = "SELECT ID FROM detai_loaidetai WHERE detai_ID = $de_tai_id AND loaidetai_ID = $hinhthuc";
                $result7_id = mysqli_query($conn,$sql7_id);
                $row7_id = mysqli_fetch_array($result7_id);
                $detai_loaidetai_id = $row7_id['ID'];
    
                $sql8 = "INSERT INTO bangdt(phutrach_ID, detai_loaidetai_ID, nam_hoc, hoc_ky) VALUES ( $phutrach_ID , $detai_loaidetai_id, $nam, $hocky)";
                $result8 = mysqli_query($conn,$sql8);
                $sql8_id = "SELECT ID FROM bangdt WHERE phutrach_ID= $phutrach_ID AND detai_loaidetai_ID = $detai_loaidetai_id AND nam_hoc = $nam AND hoc_ky = $hocky";
                $result8_id = mysqli_query($conn,$sql8_id);
                $row8_id = mysqli_fetch_array($result8_id);
                $bangdt_ID = $row8_id['ID'];
                if($count1 == 0){
                    $sql10 = "INSERT INTO dangky_detai(taikhoan_id,bangdt_ID,trangthai_ID,nam_hoc,hoc_ky) VALUES ($taikhoan_ID , $bangdt_ID,  $de_xuat_id, $nam, $hocky)";
                    $result10 = mysqli_query($conn,$sql10);
                    echo"<script>Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Đã đề xuất đề tài mới!',
                        confirmButtonText: 'Xác nhận',
                      })</script>"; 
                }
                else{
                    $sql10 = "UPDATE dangky_detai SET bangdt_ID = '$bangdt_ID', trangthai_ID = $cho_duyet_id WHERE taikhoan_ID = '$taikhoan_ID' AND nam_hoc = '$nam' AND hoc_ky = '$hocky'";
                    $result10 = mysqli_query($conn,$sql10);
                    echo"<script>Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Đã đề xuất đề tài mới!',
                        confirmButtonText: 'Xác nhận',
                      })</script>"; 
                }
            }
            else echo"<script>Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Chưa đăng kí giáo viên!',
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
                        <h2>Đăng kí giảng viên và hình thức</h2>
                        <?php
                            if($count1 != 0){
                                $sql = "SELECT ten_loai FROM loaidetai WHERE ID = '$hinhthuc'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo '<a class="detai"><h2>'. $row["ten_loai"].'</h2></a>';
                            }
                        ?>
                    </div>
                    <form action="sv_detai.php" method="POST">
                        <div class="row50">
                            <div class="input-box">
                                <span>Giảng viên hướng dẫn đề tài</span>
                                <select name="gv">
                                    <option value ="0"></option>
                                    <?php
                                        $sql ="SELECT ID,ho_ten FROM taikhoan WHERE vai_tro = 2 and chuyennganh_ID = $chuyennganh_ID";
                                        $result = mysqli_query($conn, $sql);
                                        while( $row = mysqli_fetch_assoc($result)){    
                                            if($row['ID'] == $_SESSION['phutrach_ID']){
                                                echo '<option value="'.$row['ID'].'" selected>'. $row['ho_ten'] .'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$row['ID'].'">'. $row['ho_ten'] .'</option>';
                                            }
                                        }
                                           
                                    ?>
                                </select>
                            </div>
                            <div class="input-box">
                                <span>Học kì này bạn làm niên luận gì</span>
                                <div class="radio-group">
                                    <label class="radio">
                                        <input type="radio" name="type" value="<?php echo $nlcs_ID ?>">Niên luận cơ sở
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="<?php echo $nln_ID ?>"> Niên luận ngành
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="xacnhan" value="Xác nhận">
                            </div>
                        </div>
                    <!-- </form> -->
                    <div class="cardHeader">
                        <h2>Đăng kí đề tài</h2>
                    </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Tên đề tài</span>
                                <select name= "bangdt_ID">
                                    <option value ="0"></option>
                                    <?php
                                    $phutrach_ID = $_SESSION['phutrach_ID'];
                                    $sql ="SELECT tenDT,bangdt.ID 
                                        FROM detai JOIN detai_loaidetai ON detai_ID = detai.ID 
                                        JOIN bangdt ON detai_loaidetai_ID =detai_loaidetai.ID
                                        WHERE phutrach_ID = '$phutrach_ID' AND chinhthuc = 1  AND bangdt.nam_hoc = '$nam' AND bangdt.hoc_ky = '$hocky' AND loaidetai_ID = '$hinhthuc'";
                                    $result = mysqli_query($conn, $sql);
                                    while( $row = mysqli_fetch_assoc($result)){    
                                        if($row['ID'] == $row1['ID']){
                                            echo '<option value="'.$row['ID'].'" selected>'. $row['tenDT'] .'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$row['ID'].'">'. $row['tenDT'] .'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="dangki" value="Đăng kí">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đề xuất đề tài mới</h2>
                    </div>
                    <form action="sv_detai.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <span>Đề xuất</span>
                                <input type="text" name="dtmoi" required autocomplete="off"></input>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Mô tả</span>
                                <textarea name="mota_dexuat" rows="5" required autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="dexuat" value="Đề xuất">
                            </div>
                        </div>
                    </form>
                    <div class="cardHeader">
                        <h2>Bảng đề tài</h2>
                    </div>
                    <table id="example"  style="width:100%">
                        <thead>
                            <tr>
                                <td>Tên</td>
                                <td>Mô tả</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php      
                            if($hinhthuc != '' && $phutrach_ID !=''){                              
                                    $sql = "SELECT tenDT, mo_taDT
                                    FROM bangdt JOIN detai_loaidetai ON detai_loaidetai.ID = detai_loaidetai_ID
                                    JOIN detai ON detai.ID = detai_ID
                                    WHERE phutrach_ID = '$phutrach_ID' AND chinhthuc = 1 AND loaidetai_ID = '$hinhthuc' AND hoc_ky = '$hocky' AND nam_hoc = '$nam'";
                                    $result = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($result)){           
                            ?>
                                <tr>
                                    <td><?php echo $row["tenDT"]; ?></td>
                                    <td><?php echo $row["mo_taDT"]; ?></td>
                                </tr>
                                <?php }}
                                ?>
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