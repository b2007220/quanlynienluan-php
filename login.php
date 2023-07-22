<?php
    session_start();
    include('./validate.php');
    include('./conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/login.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Trang đăng nhập</title>
</head>
<body?>
    <?php 
        if(isset($_POST['dangnhap'])){
            $taikhoan = addslashes($_POST['taikhoan']);
            $matkhau = md5(addslashes($_POST['matkhau']));
            $sql = "SELECT ID,tenTK,mat_khau,vai_tro,trang_thaiTK FROM taikhoan WHERE tenTK = '$taikhoan'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if(mysqli_num_rows($result) == 0){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tài khoản của bạn không tồn tại!',
                  })</script>";
            }
            else if($row['mat_khau'] != $matkhau ) {
                echo"<script>Swal.fire({
                    icon: 'warning',
                    title: 'Lỗi',
                    text: 'Nhập sai mật khẩu!',
                  })</script>";
            }
            else if($row['trang_thaiTK'] == 0){
                echo"<script>Swal.fire({
                    icon: 'warning',
                    title: 'Lỗi',
                    text: 'Tài khoản của bạn đã bị vô hiệu hóa!',
                  })</script>";
            }
            else{
                $_SESSION['taikhoan_ID']=$row['ID'];
                $_SESSION['vai_tro']= $row['vai_tro'];
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Đăng nhập thành công!',
                    confirmButtonText: 'Xác nhận',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = 'login.php';
                    }
                  })</script>";
            }           
        }
    ?>
    <div class="login-box">
        <div class="button-box">
            <div id ="btn1"></div>
            <a href="login.php">
                <button type ="button" class="toggle-btn" >Đăng nhập</button>
            </a>
            <a href="active.php">
                <button type ="button" class="toggle-btn" >Kích hoạt</button>
            </a>
        </div>
        <div class="form-container">
            <form method="post" id="dangnhap" action="login.php">
                <div class="user-box">
                    <input type="text" name="taikhoan" required="" autocomplete="off">
                    <label for="taikhoan">Tài khoản</label>
                </div>
                <div class="user-box">
                    <input type="password" name="matkhau" required="" autocomplete="off">
                    <label for="matkhau">Mật khẩu</label>
                </div>
                <button type="submit" name="dangnhap">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Đăng nhập   
                </button>
            </form>
        </div>
    </div>
    </body>
</html>