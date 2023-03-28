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
    <title>Đề tài sinh viên</title>
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
        $sql = "SELECT chuyennganh_ID FROM TAIKHOAN WHERE ID = $taikhoan_ID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $chuyennganh_ID = $row['chuyennganh_ID'];
        
        $hinhthuc = '';
        $phutrach_ID ='';

        //tìm id giảng viên và hình thức
        $sql1 = "SELECT phutrach_ID, loaidetai_ID,dangky_detai.ID
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
                $tenDT = addslashes($_POST['detai']);
                // lấy ID đề tài năm nay
                $sql4 = "SELECT bangdt.ID
                FROM detai JOIN detai_loaidetai ON detai.ID = detai_ID
                JOIN bangdt ON detai_loaidetai.ID = detai_loaidetai_ID
                WHERE tenDT = '$tenDT' AND bangdt.nam_hoc = '$nam' AND bangdt.hoc_ky = '$hocky' AND phutrach_ID = '$phutrach_ID'";
                $result4 = mysqli_query($conn,$sql4);
                $count4 = mysqli_num_rows($result4);
                if($count4 != 0){
                    $row4 = mysqli_fetch_array($result4);
                    $bangdt_ID = $row4['ID'];
                    if($count1 == 0){
                        $sql6 = "INSERT INTO dangky_detai VALUES ('$taikhoan_ID', '$bangdt_ID',2,'$hocky','$nam')";
                        $result6 = mysqli_query($conn,$sql6);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Đăng kí đề tài thành công!',
                        })</script>";
                    }
                    else{
                        $sql5 = "UPDATE dangky_detai SET bangdt_ID = '$bangdt_ID' WHERE taikhoan_ID = '$taikhoan_ID' AND nam_hoc = '$nam' AND hoc_ky = '$hocky'";
                        $result5 = mysqli_query($conn,$sql5);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Cập nhật đề tài thành công!',
                        })</script>";
                    }
                }
                else{
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Không tìm thấy đề tài của giảng viên!',
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
            $ten_dexuat = addslashes($_POST['dtmoi']);
            $mota_dexuat = addslashes($_POST['mota_dexuat']);
            $phutrach_ID = $_SESSION['phutrach_ID'];
            $hinhthuc = $_SESSION['hinhthuc'];

            $sql6 = "INSERT INTO detai(tenDT, mo_taDT) VALUES ('$ten_dexuat','$mota_dexuat)";
            $result6 = mysqli_query($conn,$sql6);
            $sql6_id = "SELECT ID FROM detai WHERE tenDT='$ten_dexuat' AND mo_taDT='$mota_dexuat'";
            $row6_id = mysqli_fetch_array($sql6_id);

            $sql7 = "INSERT INTO detai_loaidetai(detai_ID,loaidetai_ID) VALUES ($hinhthuc,$row6_id['ID'])";
            $result7 = mysqli_query($conn,$sql7);
            $sql7_id = "SELECT ID FROM detai_loaidetai WHERE detai_ID = $hinhthuc AND loaidetai_ID = $row6_id['ID']";
            $result7_id = mysqli_query($conn,$sql7_id);
            $row7_id = mysqli_fetch_array($sql7_id);

            $sql8 = "INSERT INTO bangdt(phutrach_ID,detai_loaidetai_ID,nam_hoc,hoc_ky) VALUES ($phutrach_ID , $row7_id['ID'], $nam, $hocky)";
            $result8 = mysqli_query($conn,$sql8);
            $sql8_id = "SELECT ID FROM bangdt WHERE phutrach_ID=$phutrach_ID AND detai_loaidetai_ID = $row7_id['ID'] AND nam_hoc = $nam AND hoc_ky = $hocky";
            $result8_id = mysqli_query($conn,$sql8_id);
            $row8_id = mysqli_fetch_array($sql8_id);

            $sql9 = "INSERT INTO dangky_detai(taikhoan_id,bangdt_ID,trangthai_ID,nam_hoc,hoc_ky) VALUES ($phutrach_ID , $row7_id['ID'], $nam, $hocky)";
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
                                <span>Giáo viên hướng dẫn đề tài</span>
                                <select name="gv">
                                    <?php
                                        $sql ="SELECT ho_ten,id FROM taikhoan WHERE vai_tro = 2 and chuyennganh_ID = $chuyennganh_ID";
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
                                        <input type="radio" name="type" value="1">Niên luận cơ sở
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="2"> Niên luận ngành
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
                    </form>
                    <div class="cardHeader">
                        <h2>Đăng kí đề tài</h2>
                    </div>
                    <form action="sv_detai.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <!-- <?php
                                    $sql = "SELECT tenDT
                                    FROM detai JOIN detai_loaidetai ON detai_ID = detai.ID
                                            JOIN bangdt ON detai_loaidetai_ID = detai_loaidetai.ID
                                            JOIN dangky_detai ON bangDT_ID = bangDT.ID
                                    WHERE taikhoan_ID = '$taikhoan_ID' AND dangky_detai.nam_hoc = '$nam' AND dangky_detai.hoc_ky = '$hocky'";
                                    $result = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($result);
                                    if($count == 0){
                                        $tendt = '';
                                    }
                                    else{
                                        $row = mysqli_fetch_assoc($result);
                                        $tendt = $row['tenDT'];
                                    }     
                                ?> -->
                                <span>Tên đề tài</span>
                                <select name="detai">
                                    <?php
                                    $sql ="SELECT tenDT,bangdt.ID 
                                        FROM detai JOIN detai_loaidetai ON detai_ID = detai.ID 
                                        JOIN bangdt ON detai_loaidetai_ID =detai_loaidetai.ID
                                        WHERE phutrach_ID = '$phutrach_ID' and bangdt.nam_hoc = '$nam' and bangdt.hoc_ky = '$hocky' and loaidetai_ID = '$hinhthuc'";
                                    $result = mysqli_query($conn, $sql);
                                    while( $row = mysqli_fetch_assoc($result)){    
                                        if($row['bangdt.ID'] == $row1['dangky_detai.ID']){
                                            echo '<option value="'.$row['bangdt.ID'].'" selected>'. $row['tenDT'] .'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$row['bangdt.ID'].'">'. $row['tenDT'] .'</option>';
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
                    <table>
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
                                    WHERE phutrach_ID = '$phutrach_ID' AND loaidetai_ID = '$hinhthuc' AND hoc_ky = '$hocky' AND nam_hoc = '$nam'";
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