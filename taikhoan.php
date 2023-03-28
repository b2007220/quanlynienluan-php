<?php
    session_start();
    include('sendmail.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/login.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Kích hoạt tài khoản</title>
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
                header('location:ad_ql_gv.php');
            }

        }
        function domain_exists($email, $record = 'MX'){
            list($user, $domain) = explode('@', $email);
            return checkdnsrr($domain, $record);
        }
        if(isset($_POST['kichhoat'])){
            $taikhoan = addslashes($_POST['taikhoan']);
            if(domain_exists($taikhoan)){
                if(strpos($taikhoan,"@ctu.edu.vn") == false && strpos($taikhoan,"@student.ctu.edu.vn") == false){
                    echo"<script>Swal.fire({
                            icon: 'warning',
                            title: 'Lỗi',
                            text: 'Vui lòng nhập email có đuôi là ctu.edu.vn!',
                          })</script>";
                }
                else{
                    $sql = "SELECT ID FROM taikhoan WHERE tenTK = '$taikhoan'";   
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if(mysqli_num_rows($result) > 0){
                        echo"<script>Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã có tài khoản gán với email này!',
                          })</script>";
                    }
                    else{
                        $matkhau = uniqid();
                        $mail = new Mail();
                        $subject = 'Mật khẩu Website Quản lí niên luận';
                        $body = 'Chào '.$taikhoan. ',<br>Mật khẩu website của bạn là: <br><b>'. $matkhau.'</b><br>Vui lòng không chia sẻ mật khẩu của bạn cho ai.<br>Thân chào';
                        $_SESSION['demo_tai_khoan'] = $taikhoan;
                        $_SESSION ['mat_khau'] = $matkhau;
                        $mail -> kichhoat($taikhoan,$matkhau,$subject,$body);
                    }
                }  
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tài khoản email không tồn tại!',
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
            <form method="post" action="taikhoan.php" id="kichhoat">                
                    <div class="user-box">
                        <input type="text" name="taikhoan" required="" autocomplete="off">
                        <label for="taikhoan">Email trường</label>
                    </div>                
                    <button type= "submit" name="kichhoat">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Kích hoạt  
                </button>
            </form>   
        </div>
    </div>
    </body>

</html>