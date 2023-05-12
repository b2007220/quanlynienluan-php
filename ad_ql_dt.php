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
    <title>Quản lí đề tài</title>
</head>

<body>
    <?php 
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");

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
        if(isset($_POST['xoa'])){
            $CN_ID = $_POST['xoa'];
            $sql = "DELETE FROM detai WHERE ID = $CN_ID";
            $result = mysqli_query($conn,$sql);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Xóa chuyên ngành thành công!',
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
                        <h2>Bảng đề tài</h2>
                    </div>
                    <form action="ad_ql_dt.php" method="POST">
                        <table id ="example" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Tên đề tài</td>
                                    <td>Mô tả đề tài</td>
                                    <td>Xóa</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT * FROM detai";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["tenDT"]; ?></td>
                                    <td><?php echo $row["mo_taDT"]; ?></td>
                                    <td><button class="btn" name="xoa" value="<?php echo $row["ID"]; ?>">
                                            <ion-icon name="close-outline"></ion-icon></ion-icon>
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