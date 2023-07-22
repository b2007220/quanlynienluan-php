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
    <title>Đề tài giảng viên</title>
</head>

<body>
    <?php 
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 
        if(isset($_POST['sudunglai'])){
            $detai_loaidetai_ID = $_POST['sudunglai'];
            $sql = "SELECT bangdt.ID 
            FROM bangdt
            WHERE detai_loaidetai_ID = '$detai_loaidetai_ID' AND nam_hoc = '$nam' AND hoc_ky = '$hocky'";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            if($count > 0){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đề tài đã tồn tại ở học kỳ này!',
                    })</script>";
            }
            else{
                $sql = "INSERT INTO bangdt (detai_loaidetai_ID,nam_hoc,hoc_ky,phutrach_ID) VALUES ('$detai_loaidetai_ID', '$nam', '$hocky', '$taikhoan_ID')";
                $result = mysqli_query($conn,$sql);
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Thêm đề tài thành công!',
                    })</script>";
            }
        }
        if(isset($_POST['xem'])){
            $_SESSION['bangdt_ID'] = $_POST['xem'];
            $bangdt_ID = $_POST['xem'];
            $sql = "SELECT ID FROM dangky_detai WHERE bangdt_ID = '$bangdt_ID'";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            if($count > 0){
                header('location:gv_lichsu.php');
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Thông báo',
                    text: 'Không tìm thấy sinh viên nào làm đề tài  !',
                    })</script>";
            }
        }
    ?>
    <div class="container">
        <?php
        include('./navigation.php')
        ?>
        <div class="main">
            <!-- topbar -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="username">
                <?php
                        $sql = "SELECT ho_ten, gioitinh_id,tenTK FROM taikhoan WHERE ID = '$taikhoan_ID'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $loichao = "Chào ";
                        if($row['ho_ten'] != ''){
                            if($row['gioitinh_id'] == 2){
                                $loichao = $loichao . "thầy ";
                            }
                            else if($row['gioitinh_id'] == 3){
                                $loichao = $loichao . "cô ";
                            } 
                            echo '<h2>'.$loichao .$row['ho_ten'].'<h2>'; 
                        }
                        else{
                            echo '<h2>'.$loichao .$row['tenTK'].'<h2>'; 
                        }
                    ?>
                </div>
            </div>
            <!-- detail list-->
            <div class="detail">
            <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đề tài</h2>
                        <div class="button-box">
                            <div id ="btn2"></div>
                            <a href="./record.php">
                                <button type ="button" class="toggle-btn2" >Lịch sử</button>
                            </a>
                            <a href="./all_project.php">
                                <button type ="button" class="toggle-btn1">Đề tài các năm</button>
                            </a>
                        </div>
                    </div>
                    <form action="all_project.php" method="POST">
                        <table id="example"  style="width:100%">
                            <thead>
                                <tr>
                                    <td>Tên đề tài</td>
                                    <td>Hình thức</td>
                                    <td>Mô tả</td>
                                    <td>Năm</td>
                                    <td>Học kỳ</td>
                                    <td>Xem lịch sử</td>
                                    <td>Sử dụng lại</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql ="SELECT bangdt.ID ,detai_loaidetai_ID,tenDT, mo_taDT,ten_loai,nam_hoc,hoc_ky FROM bangdt
                                    JOIN detai_loaidetai on detai_loaidetai.ID = detai_loaidetai_ID
                                    JOIN detai on detai.ID = detai_ID
                                    JOIN loaidetai on loaidetai.ID = loaidetai_ID
                                    WHERE phutrach_ID = '$taikhoan_ID' AND chinhthuc = 1
                                    ORDER BY ten_loai,nam_hoc,hoc_ky";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><?php echo $row['tenDT']; ?></td>
                                    <td><?php echo $row['ten_loai']; ?></td>
                                    <td><?php echo $row['mo_taDT']; ?></td>
                                    <td><?php echo $row['nam_hoc']; ?></td>
                                    <td><?php echo $row['hoc_ky']; ?></td>
                                    <td><button class="btn" name="xem" value="<?php echo $row["ID"]; ?>">
                                        <ion-icon name="eye-outline"></ion-icon>
                                        </button></td>
                                    <td><button class="btn" name="sudunglai" value="<?php echo $row["detai_loaidetai_ID"]; ?>">
                                        <ion-icon name="checkmark-outline"></ion-icon>
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