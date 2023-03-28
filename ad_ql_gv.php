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
    <title>Quản lí tài khoản</title>
</head>

<body>
    <?php 
        if(!isset($_SESSION['taikhoan'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['loai'] == 2){
            header('location:gv_nlcoso.php');
        }
        if($_SESSION['loai'] == 1){
            header('location:sv_trangchu.php');
        }
        $conn = mysqli_connect("localhost", "root", "", "nienluan");
    ?>
    <?php
    if(isset($_POST['tao'])){
        $taikhoan = addslashes($_POST['taikhoan']);
        $matkhau = addslashes($_POST['matkhau']);
        $cf_matkhau = addslashes($_POST['cf_matkhau']);
        $hotengv = addslashes($_POST['hotengv']);
        $gioitinh = addslashes($_POST['gioitinh']);
        if($gioitinh == "Nam")  $gioitinh = 1;
        else $gioitinh = 0;

        $emailgv = addslashes($_POST['emailgv']);

        if($matkhau != $cf_matkhau){
            echo"<script>alert('Mật khẩu nhập lại bị sai lệch')</script>";
        }
        else{
            $sql1= "SELECT matk from taikhoan where taikhoan = '$taikhoan'";
            $result1 = mysqli_query($conn, $sql1);
            $count1 = mysqli_num_rows($result1);
            if($count1 > 0){
                echo"<script>alert('Tài khoản đã tồn tại')</script>";
            }
            else{
                $sql2 = "SELECT matk from taikhoan";
                $result2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($result2);
                while (strlen($count2)!= 8){
                    $count2 = '0'.$count2;
                }
                $matk = $count2;
                $sql3 = "INSERT INTO taikhoan values('$matk', '$taikhoan', '$matkhau', 2)";
                $result3 = mysqli_query($conn, $sql3);

                $sql4 = "SELECT mgv FROM thongtingv";
                $result4 = mysqli_query($conn, $sql4);
                $count4 = mysqli_num_rows($result4)+1;
                while (strlen($count4)!= 6){
                    $count4 = '0'.$count4;
                }
                $mgv= 'gv'.$count4;

                $sql5 = "INSERT into thongtingv values('$matk','$mgv', '$hotengv', '$emailgv', '$gioitinh')";
                $result5 = mysqli_query($conn, $sql5);
                echo"<script>alert('Tạo tài khoản thành công')</script>";
            }
        }
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
                        <span class="title">Admin</span>
                    </a>
                </li>
                <li>
                    <a href="ad_ql_gv.php">
                        <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Tài khoản giáo viên</span>
                    </a>
                </li>
                <li>
                    <a href="ad_ql_sv.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Tài khoản sinh viên</span>
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
                    <h2>Chào Admin</h2>
                </div>
            </div>
            <!-- detail list-->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Tạo tài khoản giáo viên</h2>
                    </div>
                    <form action="ad_ql_gv.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <span>Tài khoản</span>
                                <input type="text" name="taikhoan" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="input-box">
                                <span>Mật khẩu</span>
                                <input type="password" name="matkhau" autocomplete="off"
                                    required>
                            </div>
                             <div class="input-box">
                                <span>Nhập lại mật khẩu</span>
                                <input type="password" name="cf_matkhau" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="input-box">
                                <span>Họ tên</span>
                                <input type="text" name="hotengv" autocomplete="off"
                                    required>
                            </div>
                            <div class="input-box">
                                <span>Email</span>
                                <input type="email" name="emailgv" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="row25">
                            <div class="input-box">
                                <span>Giới tính</span>
                                <input list="dsdetai" name="gioitinh" required autocomplete="off" />
                                <datalist id="dsdetai">
                                    <option value="Nam">
                                    <option value="Nữ">
                                </datalist>     
                            </div>
                        </div>   
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="tao" value="Tạo">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Bảng tài khoản giáo viên</h2>
                    </div>
                    <form action="ad_gl_gv.php" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td>Tài khoản</td>
                                    <td>MGV</td>
                                    <td>Họ và tên</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT taikhoan,mgv,hotengv FROM thongtingv t join taikhoan k on t.matk = k.matk
                                        order by mgv";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["taikhoan"];?></td>
                                    <td><?php echo $row["mgv"]; ?></td>
                                    <td><?php echo $row["hotengv"];?></td>                                   
                                </tr>
                                <?php }
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