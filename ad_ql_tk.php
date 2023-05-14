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
    <title>Quản lí tài khoản</title>
</head>

<body>
    <?php 
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");
        $conn -> set_charset("utf8");

        if(!isset($_SESSION['taikhoan_ID'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['vai_tro'] == 1){
            header('location:sv_trangchu.php');
        }
        if($_SESSION['vai_tro'] == 2){
            header('location:gv_nlcoso.php');
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
        
        if(isset($_POST['kichhoat'])){
            $taikhoan_ID = $_POST['kichhoat'];
            $sql = "SELECT trang_thaiTK FROM taikhoan WHERE ID = $taikhoan_ID";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row['trang_thaiTK'] == 1){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tài khoản vẫn đang hoạt động!',
                    })</script>";
            }
            else{
                $sql = "UPDATE taikhoan SET trang_thaiTK = 1 WHERE ID = $taikhoan_ID";
                $result = mysqli_query($conn, $sql);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Tái kích hoạt tài khoản thành công!',
                    })</script>";
            }
        }
                
        if(isset($_POST['vohieu'])){
            $taikhoan_ID = $_POST['vohieu'];
            $sql = "SELECT trang_thaiTK FROM taikhoan WHERE ID = $taikhoan_ID";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row['trang_thaiTK'] == 0){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tài khoản đã bị vô hiệu hóa từ trước!',
                    })</script>";
            }
            else{
                $sql = "UPDATE taikhoan SET trang_thaiTK = 0 WHERE ID = $taikhoan_ID";
                $result = mysqli_query($conn, $sql);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Vô hiệu tài khoản thành công!',
                    })</script>";
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
                    <a href="ad_ql_tk.php">
                        <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lí tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="ad_ql_cn.php">
                        <span class="icon">
                        <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lí chuyên ngành</span>
                    </a>
                </li>
                <li>
                    <a href="ad_ql_dt.php">
                        <span class="icon">
                        <ion-icon name="save-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lí đề tài</span>
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
            <div class="detail">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Bảng tài khoản</h2>
                    </div>
                    <form action="ad_ql_tk.php" method="POST">
                        <table id ="example" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Tài khoản</td>
                                    <td>Họ và tên</td>
                                    <td>Giới tính</td>
                                    <td>Chuyên ngành</td>
                                    <td>Vai trò</td>
                                    <td>Trạng thái</td>
                                    <td>Quản lý</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT ho_ten, tenTK, vai_tro, tenGT , tenCN, taikhoan.ID, trang_thaiTK
                                FROM taikhoan JOIN chuyennganh ON chuyennganh_ID = chuyennganh.ID
                                JOIN gioitinh ON gioitinh_ID = gioitinh.ID
                                WHERE vai_tro = 2 OR vai_tro = 1
                                ORDER BY vai_tro";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["tenTK"]; ?></td>
                                    <td><?php echo $row["ho_ten"]; ?></td>
                                    <td><?php echo $row["tenGT"]; ?></td>
                                    <td><?php echo $row["tenCN"]; ?></td>
                                    <td><?php
                                        if($row["vai_tro"] == 1){
                                            echo '<span class="status finish">Sinh viên</span>';
                                        }
                                        else if($row["vai_tro"] == 2){
                                            echo '<span class="status process">Giảng viên</span>';
                                        }
                                        else if($row["vai_tro"] == 0){
                                            echo '<span class="status wait">Admin</span>';
                                        }
                                    ?></td>
                                    <td><?php
                                        if($row["trang_thaiTK"] == 1){
                                            echo '<span class="status finish">Hoạt động</span>';
                                        }
                                        else if($row["trang_thaiTK"] == 0){
                                            echo '<span class="status wait">Vô hiệu hóa</span>';
                                        }
                                    ?></td>
                                    <td><button class="btn" name="kichhoat" value="<?php echo $row["ID"]; ?>">
                                    <ion-icon name="log-in-outline"></ion-icon>
                                            </button>
                                    <button class="btn" name="vohieu" value="<?php echo $row["ID"]; ?>">
                                    <ion-icon name="log-out-outline"></ion-icon>
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
