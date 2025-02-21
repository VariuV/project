<?php
session_start();
include 'nav.php';
include '../connectdb.php';
include '../function.php';
include 'check_login.php';



if (isset($_POST['btn'])) {
    $gv_id = $_POST['gv'];  
    $major_id = $_POST['major'];  

    // Cập nhật id_manager trong bảng major
    $sql_update = "UPDATE `major` SET `id_manager` = '$gv_id' WHERE `id_major` = '$major_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<p class='success-message'>Phân công giáo viên thành công!</p>";
    } else {
        echo "<p class='error-message'>Lỗi: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/phan_cong_gv.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân công giáo viên xét duyệt</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
   
</style>
<body>

    <div class="form-container">
        <h2 class="form-heading">Phân công giáo viên xét duyệt</h2>
        <form action="" method="post" class="assignment-form">
            <label for="gv" class="label">Chọn giáo viên</label>
            <select name="gv" id="gv" class="select">
                <?php intengv(); ?>
            </select>
            <br>
            <label for="major" class="label">Chọn ngành</label>
            <select name="major" id="major" class="select">
                <?php intennganh(); ?>
            </select>
            <br>
            <input type="submit" value="Gửi" name="btn" class="btn-submit">
        </form>
    </div>

    <div class="table-container">
        <h2 class="table-heading">Danh sách phân công</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên giáo viên</th>
                    <th>Tên ngành</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php in_bang_phan_cong(); ?>
            </tbody>
        </table>
    </div>

</body>
</html>

