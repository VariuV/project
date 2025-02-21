<?php
session_start();
include 'nav.php';
include '../connectdb.php';
include '../function.php';
include 'check_login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="css/nganh_hoc.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <a href="trang_chu.php" class=" return">Trở về </a>

    <div class="container_content">
        <h2>Thêm ngành học mới</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Tên ngành</label>
                <input type="text" name="major_name" class="form-control" id="username" placeholder="Nhập tên nganh hoc" required>
            </div>
            <br>
            <div class="form-group">
                <label for="subject_gr">Tổ hợp môn</label><br>
                <input type="radio" name="subject_gr" value="1" required> A00<br>
                <input type="radio" name="subject_gr" value="2" required> A01<br>
                <input type="radio" name="subject_gr" value="3" required> C00<br>
                <input type="radio" name="subject_gr" value="4" required> D01<br>
                <br>
            </div>
            <div class="form-group">
                <label for="start_time">Thời gian bắt đầu</label>
                <input type="date" name="start_time" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="start_time">Thời gian kết thúc</label>
                <input type="date" name="end_time" class="form-control" id="username" required>
            </div>
            <button type="submit" name="gui" class="btn btn-primary btn-block">Tạo</button>
        </form>
        <?php
        if (isset($_POST['gui'])) {
            $major_name = $_POST['major_name'];
            $subject_group = $_POST['subject_gr']; 
            $start = $_POST['start_time'];
            $end = $_POST['end_time'];
            global $conn;

            // Hàm chèn dữ liệu
            if (in_nghanh($major_name, $subject_group, $start, $end)) {
                echo "Thêm ngành học thành công!";
            } else {
                echo "Có lỗi xảy ra khi thêm ngành học: " . mysqli_error($conn);
            }
        }

        $_SESSION['dagui'] = isset($_POST['gui']);
        ?>
    </div>
    <?php
    echo "<table border='1'>
        <tr>
            <td>ID</td>
            <td>Tên ngành học</td>
            <td>Tổ hợp</td>
            <td>Ngày bắt đầu</td>
            <td>Ngày kết thúc</td>";
    if ($_SESSION['role'] == 0) {
        echo "<td>Chức năng</td>";
    }
    echo "</tr>";

    laythongtin();

    echo "</table>";

    chucnangbang();
    ?>

</body>

</html>