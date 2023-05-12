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
        // Function to create the cookie
        function createCookie(name, value, days) {
            var expires;
            
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
            
            document.cookie = escape(name) + "=" +
            escape(encodeURIComponent(value)) + expires + "; path=/";
        }
    </script>
    <title>Quản lí chuyên ngành</title>
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
        if(isset( $_COOKIE["du_lieu_moi"]) && isset($_SESSION['CN_ID'])){
            $CN_ID = $_SESSION['CN_ID'];
            $du_lieu_moi = urldecode($_COOKIE['du_lieu_moi']);
            $tenCN = $du_lieu_moi;
            $sql = "UPDATE chuyennganh SET tenCN = '$tenCN' WHERE ID = $CN_ID";
            $result = mysqli_query($conn,$sql);
            unset($_SESSION['CN_ID']);
            unset($_COOKIE['du_lieu_moi']);
        }
        if(isset($_POST['chinhsua'])){
            $_SESSION['CN_ID'] = $_POST['chinhsua'];
            echo "<script>
            (async () => {
                const { value: formValues } = await Swal.fire({
                    title: 'Tên chuyên ngành',
                    input: 'text',
                  })
                if (formValues) {
                    createCookie(\"du_lieu_moi\", formValues);
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Chỉnh sửa tên đề tài thành công!',
                        confirmButtonText: 'Xác nhận',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = 'ad_ql_cn.php';
                      }
                    })
                }
                })()
            </script>";
        }
        if(isset($_POST['them'])){
            $tenCN = $_POST['tenCN'];
            $sql = "INSERT INTO `chuyennganh` (`ID`, `tenCN`) VALUES (NULL, '$tenCN');";
            $result = mysqli_query($conn,$sql);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Thêm chuyên ngành thành công!',
              })</script>"; 
        }
        if(isset($_POST['xoa'])){
            $CN_ID = $_POST['xoa'];
            $sql = "DELETE FROM chuyennganh WHERE ID = '$CN_ID'";
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
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Bảng chuyên ngành</h2>
                    </div>
                    <form action="ad_ql_cn.php" method="POST">
                        <table id ="example" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Tên chuyên ngành</td>
                                    <td>Chỉnh sửa</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql ="SELECT * FROM chuyennganh";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $row["tenCN"]; ?></td>
                                    <td><button class="btn" name="chinhsua" value="<?php echo $row["ID"]; ?>">
                                        <ion-icon name="create-outline"></ion-icon>
                                            </button>
                                            <button class="btn" name="xoa" value="<?php echo $row["ID"]; ?>">
                                            <ion-icon name="close-outline"></ion-icon></ion-icon>
                                            </button></td>
                                </tr>
                                <?php }
                            ?>
                            </tbody>
                        </table>
                   </form>
                </div>
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Thêm chuyên ngành</h2>
                    </div>
                    <form action="ad_ql_cn.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <span>Tên chuyên ngành</span>
                                <input type="text" name="tenCN" required autocomplete="off"></input>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="them" value="Thêm">
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