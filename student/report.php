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
    <title>Báo cáo tiến độ</title>
</head>

<body>
    <?php 
        $taikhoan_ID = $_SESSION['taikhoan_ID']; 
        if(isset($_POST['them'])){
            $sql1 = "SELECT dangky_detai.ID,ten_trang_thai
            FROM dangky_detai JOIN trangthai ON trangthai.ID = trangthai_ID 
            WHERE taikhoan_ID = '$taikhoan_ID' AND nam_hoc = '$nam' AND hoc_ky = '$hocky'";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            if(!isset($row1['ID'])){
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Bạn chưa đăng kí đề tài!',
                  })</script>";
            }
            else{
                if($row1['ten_trang_thai'] == 'Đề xuất' || $row1['ten_trang_thai'] == 'Chờ duyệt' ){
                    echo"<script>Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng đợi phản hồi của giảng viên!',
                      })</script>";
                }
                else if($row1['ten_trang_thai'] == 'Hoàn thành'){
                    echo"<script>Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Bạn đã hoàn thành niên luận!',
                      })</script>";
                }
                else{
                    $dangky_detai_ID = $row1['ID'];
                    $date_report = addslashes($_POST['date-rp']);
                    $date_end = addslashes($_POST['date-e']);
                    $report_done = addslashes($_POST['work1']);
                    $report_future = addslashes($_POST['work2']);
                    if(strtotime($today) > strtotime($date_report) || strtotime($date_end) < strtotime($date_report) ||strtotime($today) > strtotime($date_report)){
                        echo"<script>Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Ngày không hợp lệ!',
                        })</script>";
                    }
                    else{
                        $sql3 = "INSERT INTO baocao (dangky_detai_ID, ngay_bao_cao, nd_thuc_hien, nd_sap_toi, thoi_han) 
                            VALUES ('$dangky_detai_ID', '$date_report', '$report_done', '$report_future', '$date_end')";
                        $result3 = mysqli_query($conn, $sql3);
                        echo"<script>Swal.fire({
                            icon: 'info',
                            title: 'Thông báo',
                            text: 'Báo cáo tiến độ thành công!',
                        })</script>";
                    }
                }
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
            <!-- detail list-->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Báo cáo tiến độ</h2>
                        <?php
                            $sql="SELECT tenDT FROM dangky_detai JOIN bangdt ON bangdt_ID = bangdt.ID
                            JOIN detai_loaidetai ON detai_loaidetai.ID = detai_loaidetai_ID
                            JOIN detai ON detai_ID = detai.ID 
                            WHERE taikhoan_ID = '$taikhoan_ID' AND dangky_detai.nam_hoc = '$nam' AND dangky_detai.hoc_ky = '$hocky'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $count = mysqli_num_rows($result);
                        if($count != 0){
                            echo '<a class="detai"><h2>'. $row["tenDT"].'</h2></a>';
                        }
                        ?>
                    </div>
                    <form action="report.php" method="POST">
                        <div class="row50">
                            <div class="input-box">
                                <span>Ngày báo cáo</span>
                                <input type="date" value="<?php echo $today; ?>" name="date-rp">
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Công việc đã thực hiện</span>
                                <textarea name="work1" cols="30" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Công việc chuẩn bị thực hiện</span>
                                <textarea name="work2" cols="30" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="input-box">
                                <span>Thời hạn</span>
                                <input type="date" name="date-e" value="<?php echo $new_date; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <input type="submit" name="them" value="Nộp">
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