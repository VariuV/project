<?php
session_start();
include 'nav.php';
include '../connectdb.php';
include '../function.php';
include 'check_login.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
<link rel="stylesheet" href="css/trang_chu.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Trang Chủ</title>

</head>

</style>

<body>


    <!-- Phần Hero -->
    <div class="hero">
        <h1>Chào Mừng Đến Với Trang Chủ</h1>
        <p>Khám phá danh sách các khóa học của chúng tôi</p>
    </div>

    <form action="" method="post">

        <div class="container content">
            <?php
            if ($_SESSION['role'] == 0) {
                echo '<a href="nganh_hoc.php" >Thêm Ngành Học</a>';
                echo'<br>';
                echo'<br>';
                echo '<a href="phan_cong_gv.php" >Phân Công Giáo Viên</a>';
                echo'<br>';
                echo'<br>';
                // echo '<a href="xem_ho_so.php" >Các hồ sơ</a>';
                 get_all_applications_for_admin();
            }
            ?>

            <?php
            if ($_SESSION['role'] == 1)
            
                get_applications_for_teacher();
            ?>
         
            <?php 
                if($_SESSION['role'] == 2){
                    echo'<h3>Danh Sách Ngành Học</h3>';
                    
                    echo "<table border='1'>
                        <tr>
                            <td>ID</td>
                            <td>Tên ngành học</td>
                            <td>Tổ hợp</td>
                            <td>Ngày bắt đầu</td>
                            <td>Ngày kết thúc</td>
                            <td>Chức năng</td>";
                   
                        echo"</tr>";
                       
                        laythongtin();   
                      
                    echo"</table>";
                    
                    chucnangbang();
                    
                    


                }
             
            ?>
            
        </div>

    </form>



</html>