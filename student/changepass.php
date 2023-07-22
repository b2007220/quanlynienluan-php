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
    <title>Đổi mật khẩu</title>
</head>
<body>
    <?php 
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 
        if(isset($_POST['doi'])){
            $sql = "SELECT mat_khau FROM taikhoan where ID = '$taikhoan_ID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            $mkcu = md5(addslashes($_POST['mkcu']));
            $mkmoi = md5(addslashes($_POST['mkmoi']));
            $mkxn = md5(addslashes($_POST['mkxn']));

            if(strcmp($row['mat_khau'],$mkcu) == 0){
                if($mkmoi == $mkxn){
                    if(strcmp($row['mat_khau'],$mkmoi) == 0){
                        echo"<script>Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Mật khẩu mới và mật khẩu cũ trùng nhau!',
                          })</script>";
                    }
                    else{
                        $sql = "UPDATE taikhoan SET mat_khau = '$mkxn' WHERE ID = '$taikhoan_ID'";
                        $result = mysqli_query($conn, $sql);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Đổi mật khẩu thành công!',
                            })</script>";
                    }
                }
                else{
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Mật khẩu mới và xác nhận không khớp!',
                        })</script>";
                }
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu cũ không đúng!',
                  })</script>";
            }
        }
    ?>
    <div class="container">
        <?php
        include('navigation.php');
        ?>
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
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đổi mật khẩu</h2>
                    </div>  
                    <form action="changepass.php" method ="POST">
                    <div class="row50">
                            <div class="input-box">
                                <span>Mật khẩu cũ</span>
                                <input type="password" value="" name="mkcu" required>
                            </div>
                   </div>
                   <div class="row50">
                            <div class="input-box">
                                <span>Mật khẩu mới</span>
                                <input type="password" value="" name="mkmoi" required>
                            </div>
                   </div>
                   <div class="row50">
                            <div class="input-box">
                                <span>Xác nhận mật khẩu mới</span>
                                <input type="password" value="" name="mkxn" required>
                            </div>
                   </div>
                   <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="doi" value="Đổi">
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