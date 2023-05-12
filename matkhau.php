<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/login.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Xác nhận mật khẩu</title>
</head>
<body?>
    <?php
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
        
        if(isset($_SESSION['taikhoan_ID'])){
            if($_SESSION['vai_tro'] == 1 ){
                header('location:sv_trangchu.php');
            }
            else if($_SESSION['vai_tro'] == 2){
                header('location:gv_nlcoso.php');
            }
            else if($_SESSION['vai_tro'] == 0){
                header('location:ad_ql_tk.php');
            }
        }
        if(!isset($_SESSION['demo_tai_khoan'])){
            header('location:taikhoan.php');
        }
        $demo_taikhoan = $_SESSION['demo_tai_khoan'];
        $matkhau = $_SESSION ['mat_khau'];
        
        
        if(isset($_POST['xacnhan'])){
            $matkhau2 = addslashes($_POST['matkhau2']);
            if(strcmp($matkhau2, $matkhau) == 0){
                if(strcmp($demo_taikhoan,'@student.ctu.edu.vn')!=0){
                    $vai_tro = 1;
                }
                else{
                    $vai_tro = 2;
                }
                $matkhau = md5($matkhau);
                $sql2 = "INSERT INTO taikhoan(tenTK,mat_khau,trang_thaiTK,chuyennganh_ID,vai_tro,gioitinh_ID) VALUES ('$demo_taikhoan','$matkhau', 1,1, $vai_tro,1)";
                $result2 = mysqli_query($conn, $sql2);
                $sql3 = "SELECT ID FROM taikhoan WHERE tenTK = '$demo_taikhoan'";
                $result3 = mysqli_query($conn, $sql3);
                $row3 = mysqli_fetch_assoc($result3);
                $_SESSION['vai_tro'] = $vai_tro;
                $_SESSION['taikhoan_ID'] = $row3['ID'];
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Tài khoản của bạn được kích hoạt thành công!',
                    confirmButtonText: 'Xác nhận',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = 'dangnhap.php';
                    }
                  })</script>";
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'warning',
                    title: 'Lỗi',
                    text: 'Mật khẩu không trùng khớp!',
                  })</script>";
            }
            
        }
    ?>
    <div class="login-box">
        <div class="button-box">
            <div id ="btn2"></div>
            <a href="dangnhap.php">
                <button type ="button" class="toggle-btn" >Đăng nhập</button>
            </a>
            <a href="taikhoan.php">
                <button type ="button" class="toggle-btn" >Kích hoạt</button>
            </a>
        </div>
        <div class="form-container">
            <form method="post" action="matkhau.php" id="kichhoat">                
                <div class="user-box">
                    <input type="password" name="matkhau2" required autocomplete="off">
                    <label for="matkhau2">Mật khẩu được gửi đến</label>
                </div>
                <button type="submit" name="xacnhan">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Xác nhận 
                </button>
            </form>   
        </div>
    </div>
    </body>

</html>