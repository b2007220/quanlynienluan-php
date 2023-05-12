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
    <title>Đề tài giảng viên</title>
</head>

<body>
    <?php 
        $conn = mysqli_connect("localhost", "root", "", "nienluancoso");

        $taikhoan_ID = $_SESSION['taikhoan_ID']; 

        if(!isset($_SESSION['taikhoan_ID'])){
            header('location:dangnhap.php');
        }
        if($_SESSION['vai_tro'] == 1){
            header('location:sv_trangchu.php');
        }
        if($_SESSION['vai_tro'] == 0){
            header('location:ad_ql_tk.php');
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
        $result = mysqli_query($conn, "SELECT ID FROM loaidetai WHERE ten_loai = 'Niên luận cơ sở'");
        $row = mysqli_fetch_assoc($result);
        $id_nlcs = $row['ID'];
        $result = mysqli_query($conn, "SELECT ID FROM loaidetai WHERE ten_loai = 'Niên luận ngành'");
        $row = mysqli_fetch_assoc($result);
        $id_nln = $row['ID'];

        if(isset($_COOKIE["du_lieu_moi"])){
            $du_lieu_moi = urldecode($_COOKIE['du_lieu_moi']);
            $du_lieu_moi = explode(",", $du_lieu_moi);
            $ten_moi = $du_lieu_moi[0];
            $mo_ta_moi = $du_lieu_moi[1];
            $bangdt_ID = $du_lieu_moi[2];
            $sql = "SELECT detai.ID FROM bangdt
            JOIN detai_loaidetai ON detai_loaidetai.ID = detai_loaidetai_ID
            JOIN detai ON detai.ID = detai_ID
            WHERE bangdt.ID = '$bangdt_ID'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $detai_id = $row['ID'];
            $sql = "UPDATE detai SET tenDT = '$ten_moi', mo_taDT = '$mo_ta_moi'  WHERE ID = '$detai_id'";
            $result = mysqli_query($conn,$sql);
            unset($_COOKIE['du_lieu_moi']);
        }

        if(isset($_POST['them'])){
            $mota = addslashes($_POST['mota']);
            $hinhthuc = $_POST['type'];
            $detai = addslashes($_POST['detai']);
            $sql1 = "SELECT detai_ID,loaidetai_ID FROM detai_loaidetai 
            JOIN detai ON detai_ID = detai.ID
            WHERE tenDT LIKE '$detai'";
            $result1 = mysqli_query($conn, $sql1);
            $count1 = mysqli_num_rows($result1);
            if($count1 == 0){
                $sql3 = "INSERT INTO detai(tenDT, mo_taDT)VALUES ('$detai','$mota')";
                $result3 = mysqli_query($conn, $sql3);
                $result3_id = mysqli_query($conn, "SELECT ID FROM detai WHERE tenDT LIKE '$detai'");
                $row3 = mysqli_fetch_assoc($result3_id);
                $detai_id = $row3['ID'];
                if($hinhthuc == 1 || $hinhthuc == 3){
                    $sql = "INSERT INTO detai_loaidetai(detai_ID, loaidetai_ID, chinhthuc) VALUES ('$detai_id','$id_nlcs',1)";
                    $result = mysqli_query($conn,$sql);
                    $sql = "SELECT ID FROM detai_loaidetai WHERE detai_ID = $detai_id AND loaidetai_ID = $id_nlcs";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($result);
                    $detai_loaidetai_ID = $row['ID'];
                    $sql = "INSERT INTO bangdt(phutrach_ID,detai_loaidetai_ID,nam_hoc,hoc_ky) VALUES ('$taikhoan_ID','$detai_loaidetai_ID', $nam, $hocky)";
                    $result = mysqli_query($conn,$sql);
                }
                if ($hinhthuc == 2 || $hinhthuc == 3){
                    $sql = "INSERT INTO detai_loaidetai(detai_ID, loaidetai_ID, chinhthuc) VALUES ('$detai_id','$id_nln',1)";
                    $result = mysqli_query($conn,$sql);
                    $sql = "SELECT ID FROM detai_loaidetai WHERE detai_ID = $detai_id AND loaidetai_ID = $id_nln";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($result);
                    $detai_loaidetai_ID = $row['ID'];
                    $sql = "INSERT INTO bangdt(phutrach_ID,detai_loaidetai_ID,nam_hoc,hoc_ky) VALUES ('$taikhoan_ID','$detai_loaidetai_ID', $nam, $hocky)";
                    $result = mysqli_query($conn,$sql);
                }
                echo"<script>Swal.fire({
                    icon: 'info',
                    title: 'Thông báo',
                    text: 'Thêm đề tài thành công!',
                  })</script>";  
            }
            else{
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đề tài đã tồn tại!',
                  })</script>";
            }
        }
        
        if(isset($_POST['xoa'])){
            $bangdt_id = $_POST['xoa'];
            $sql = "DELETE FROM bangdt WHERE ID = '$bangdt_id'";
            $result = mysqli_query($conn, $sql);
            echo"<script>Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: 'Xóa đề tài thành công!',
              })</script>";
        }
        if(isset($_POST['chinhsua'])){
            $bangdt_ID = $_POST['chinhsua'];
            $sql = "SELECT tenDT, mo_taDT FROM bangdt
            JOIN detai_loaidetai on detai_loaidetai.ID = detai_loaidetai_ID
            JOIN detai on detai.ID = detai_ID
            WHERE bangdt.Id = $bangdt_ID";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $tenDT = $row['tenDT'];
            $mo_ta = $row['mo_taDT'];
            echo "<script>
            (async () => {
                const { value: formValues } = await Swal.fire({
                  title: 'Bảng chỉnh sửa',
                  html:
                    '<input id=\"swal-input1\" class=\"swal2-input\" name=\"ten_moi\" value =\"$tenDT\">' +
                    '<textarea class=\"swal2-textarea\" id=\"swal-input2\"  name=\"mota_moi\" placeholder=\"Mô tả mới của đề tài\"></textarea>',
                  focusConfirm: false,
                  preConfirm: () => {
                    return [
                      document.getElementById('swal-input1').value,
                      document.getElementById('swal-input2').value
                    ]
                  }
                })
                if (formValues) {    
                    formValues.push('$bangdt_ID');
                    createCookie(\"du_lieu_moi\", formValues);
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Thay đổi đề tài thành công!',
                        confirmButtonText: 'Xác nhận',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = 'gv_detai_hientai.php';
                      }
                    })
                }
                })()
            </script>";  
        }

    ?>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="cafe-outline"></ion-icon>
                        </span>
                        <span class="title">Giảng viên</span>
                    </a>
                </li>
                <li>
                    <a href="gv_nlcoso.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>

                        </span>
                        <span class="title">Niên luận học kỳ</span>
                    </a>
                </li>
                <li>
                    <a href="gv_detai_hientai.php">
                        <span class="icon">
                            <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Đề tài</span>
                    </a>
                </li>
                <li>
                    <a href="gv_lichsu.php">
                        <span class="icon">
                            <ion-icon name="today-outline"></ion-icon>
                        </span>
                        <span class="title">Lịch sử báo cáo</span>
                    </a>
                </li>
                <li>
                    <a href="gv_thongtin.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Thông tin giảng viên</span>
                    </a>
                </li>
                <li>
                    <a href="gv_doimatkhau.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                            </ion-icon>
                        </span>
                        <span class="title">Đổi mật khẩu</span>
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
            <div class="details">
            <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đề tài</h2>
                        <div class="button-box">
                            <div id ="btn1"></div>
                            <a href="gv_detai_hientai.php">
                                <button type ="button" class="toggle-btn1" >Năm nay</button>
                            </a>
                            <a href="gv_duyetdetai.php">
                                <button type ="button" class="toggle-btn2">Duyệt đề tài</button>
                            </a>
                        </div>
                    </div>
                    <form action="gv_detai_hientai.php" method="POST">
                        <table id="example"  style="width:100%">
                            <thead>
                                <tr>
                                    <td>Tên</td>
                                    <td>Hình thức</td>
                                    <td>Mô tả</td>
                                    <td>Thao tác</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql ="SELECT bangdt.ID,tenDT, mo_taDT,ten_loai FROM bangdt
                                    JOIN detai_loaidetai on detai_loaidetai.ID = detai_loaidetai_ID
                                    JOIN detai on detai.ID = detai_ID
                                    JOIN loaidetai on loaidetai.ID = loaidetai_ID
                                    WHERE phutrach_ID = '$taikhoan_ID' AND nam_hoc = $nam AND hoc_ky = $hocky AND chinhthuc = 1
                                    ORDER BY ten_loai";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><?php echo $row['tenDT']; ?></td>
                                    <td><?php echo $row['ten_loai']; ?></td>
                                    <td><?php echo $row['mo_taDT']; ?></td>
                                    <td><button class="btn" name="chinhsua" value="<?php echo $row["ID"]; ?>">
                                        <ion-icon name="create-outline"></ion-icon>
                                            </button>
                                    <button class="btn" name="xoa" value="<?php echo $row["ID"]; ?>">
                                        <ion-icon name="close-outline"></ion-icon>
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
                        <h2>Thêm đề tài</h2>
                    </div>
                    <form action="gv_detai_hientai.php" method="POST">
                        <div class="row100">
                            <div class="input-box">
                                <span>Loại</span>
                                <div class="radio-group">
                                    <label class="radio">
                                        <input type="radio" name="type" value="1" required> Niên luận cơ sở
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="2"> Niên luận ngành
                                        <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="type" value="3"> Cả hai
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Đề tài</span>
                                <input type="text" name="detai" required autocomplete="off"></input>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="input-box">
                                <span>Mô tả đề tài mới</span>
                                <textarea name="mota" cols="30" rows="10"></textarea>
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