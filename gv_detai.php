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
            $mota = addslashes($_POST['mota']);
            $hinhthuc = $_POST['type'];
            $detai = addslashes($_POST['detai']);
            $sql1 = "SELECT madt FROM detai WHERE ten = '$detai'";
            $result1 = mysqli_query($conn, $sql1);
            $count1 = mysqli_num_rows($result1);
            if($count1 == 0){
                $sql2 = "SELECT madt FROM detai";
                $result2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($result2)+1;
                while(strlen($count2)!= 6){
                    $count2 = '0'.$count2;
                }
                $madt = 'dt'.$count2;
                $sql3 = "INSERT INTO detai VALUES ('$madt','$hinhthuc','$detai','$mota')";
                $sql4 = "INSERT INTO sudung VALUES ('$madt', '$mgv','$year','$hocki')";
                $result3 = mysqli_query($conn, $sql3);
                $result4 = mysqli_query($conn, $sql4);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Thêm đề tài thành công!',
                  })</script>";  
            }
            else{
                $row1 = mysqli_fetch_assoc($result1);
                $madt = $row1['madt'];
                $sql4 = "UPDATE detai SET hinhthuc = '$hinhthuc' WHERE madt = '$madt'";
                $sql4 = "INSERT INTO sudung VALUES ('$madt', '$mgv','$year','$hocki')";
                $result4 = mysqli_query($conn, $sql4);  
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Cập nhật đề tài thành công!',
                  })</script>";
            }

        }
        if(isset($_POST['xoa'])){
            $madtchon = $_POST['xoa'];
            $sql = "DELETE FROM sudung WHERE madt = '$madtchon' and mgv = '$mgv' and nam = '$year' and hocki = '$hocki'";
            $result = mysqli_query($conn, $sql);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Xóa đề tài thành công!',
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
                        <span class="title">Thông tin giáo viên</span>
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
                        $sql = "SELECT hotengv,gioitinh FROM thongtingv  WHERE matk= '$matk'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $loichao = "Chào ";
                        if($row['hotengv'] != ''){
                            if($row['gioitinh']== 1){
                                $loichao = $loichao . "thầy ";
                            }
                            else{
                                $loichao = $loichao . "cô ";
                            } 
                            echo '<h2>'.$loichao .$row['hotengv'].'<h2>'; 
                        }
                        else{
                            echo '<h2>'.$loichao .$taikhoan.'<h2>'; 
                        }
                    ?>
                </div>
            </div>
            <!-- detail list-->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Thêm đề tài</h2>
                    </div>
                    <form action="gv_detai.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <span>Loại</span>
                                <div class="radio-group">
                                    <label class="radio">
                                        <input type="radio" name="type" value="1" required> Niên luận cơ sở
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="2"> Niên luận ngành
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="3"> Cả hai
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Đề tài</span>
                                <input list="dsdetai" name="detai" required autocomplete="off" />
                                <datalist id="dsdetai">
                                    <?php
                                $sql ="SELECT ten FROM detai d JOIN sudung s on s.madt = d.madt WHERE mgv = '$mgv'";
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
                                <span>Mô tả đề tài mới</span>
                                <textarea name="mota" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="them" value="Thêm">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đề tài năm nay</h2>

                    </div>
                    <form action="gv_detai.php" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td>Tên</td>
                                    <td>Hình thức</td>
                                    <td>Mô tả</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // $detai_moi_trang = !empty($_GET['per_page']) ? $_GET['per_page'] :5;
                                    // $trang_hien_tai = !empty($_GET['per_page']) ? $_GET['per_page'] :1;
                                    // $offset = ($trang_hien_tai - 1) * $detai_moi_trang;

                                    $sql ="SELECT s.madt,ten,nam,hocki,hinhthuc,mota FROM 
                                            detai d JOIN sudung s ON d.madt=s.madt 
                                            WHERE mgv = '$mgv' and hocki = '$hocki' and nam = '$year'
                                            order by hinhthuc DESC";
                                            // -- limit ". $detai_moi_trang . " OFFSET ". $offset."";
                                    
                                    $result = mysqli_query($conn, $sql);
                                    // $sql2 = "SELECT s.madt,ten,nam,hocki,hinhthuc,mota FROM 
                                    // detai d JOIN sudung s ON d.madt=s.madt 
                                    // WHERE mgv = '$mgv' and hocki = '$hocki' and nam = '$year'";
                                    // $result2 = mysqli_query($conn, $sql2);
                                    // $count = mysqli_num_rows($result2);
                                    // $tong_trang = ceil($count / $detai_moi_trang);

                                    while($row = mysqli_fetch_assoc($result)){
                                        switch($row['hinhthuc']){
                                            case 1: $loainienluan = "Niên luận cơ sở";  break;
                                            case 2: $loainienluan = "Niên luận ngành";  break;
                                            case 3: $loainienluan = "Cả hai";   break;
                                            default : $loainienluan = "";
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $row['ten']; ?></td>
                                    <td><?php echo $loainienluan; ?></td>
                                    <td><?php echo $row['mota']; ?></td>
                                    <td><button class="btn" name="xoa" value="<?php echo $row["madt"]; ?>">
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


    const plus = document.querySelector(".plus"),
        minus = document.querySelector(".minus"),
        num =   document.querySelector(".num");

        let a = 1;
        plus.addEventListener("click",()=>{
           a++;
           a = (a < 10) ? "0" + a : a;
           num.innerText = a;
           console.log("a"); 
        });
        minus.addEventListener("click",()=>{
            if( a > 1){
            a--;
            a = (a < 10) ? "0" + a : a;
            num.innerText = a;
            console.log("a"); 
            }
        });
    </script>
</body>

</html>