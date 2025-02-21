
<?php
session_start();
include '../connectdb.php';
include '../function.php';
include 'nav.php';
include 'check_login.php';

$major = suathongtin(); 
if (isset($_POST['update'])) {
    $major_name = $_POST['major_name'];
    $subject_group = $_POST['subject_group']; // Người dùng nhập tên tổ hợp (group_name)
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $id_major = $_GET['id'];

    // Tra cứu id_subject_group từ group_name
    $sql_group = "SELECT id_subject_group FROM subject_group WHERE group_name = '$subject_group'";
    $result_group = mysqli_query($conn, $sql_group);

    if (mysqli_num_rows($result_group) > 0) {
        $row = mysqli_fetch_assoc($result_group);
        $id_subject_group = $row['id_subject_group'];

        // Thực hiện cập nhật
        $sql_update = "UPDATE major 
                       SET `major_name` = '$major_name', 
                           `id_subject_group` = '$id_subject_group', 
                           `start_date` = '$start_date', 
                           `end_date` = '$end_date' 
                       WHERE id_major = '$id_major'";

        if (mysqli_query($conn, $sql_update)) {
            echo "<p class='success-message'>Cập nhật thông tin thành công!</p>";
            // header("Location: nganh_hoc.php");
            exit();
        } else {
            echo "<p class='error-message'>Lỗi khi cập nhật thông tin: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='error-message'>Tên tổ hợp không hợp lệ!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/suathongtin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin ngành học</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
   
</style>
<body>

    <div class="form-container">
        <a href="nganh_hoc.php" class="back-link">Quay lại</a>
        <h2 class="form-heading">Chỉnh sửa ngành học</h2>
        <form method="post" class="edit-form">
            <label for="major_name" class="label">Tên ngành học:</label>
            <input type="text" name="major_name" id="major_name" value="<?php echo $major['major_name']; ?>" class="input-field"><br>

            <label for="subject_group" class="label">Tổ hợp:</label>
            <input type="text" name="subject_group" id="subject_group" value="<?php echo $major['group_name']; ?>" class="input-field"><br>

            <label for="start_date" class="label">Ngày bắt đầu:</label>
            <input type="date" name="start_date" id="start_date" value="<?php echo $major['start_date']; ?>" class="input-field"><br>

            <label for="end_date" class="label">Ngày kết thúc:</label>
            <input type="date" name="end_date" id="end_date" value="<?php echo $major['end_date']; ?>" class="input-field"><br>

            <input type="submit" name="update" value="Cập nhật" class="btn-submit">
        </form>
    </div>

</body>
</html>

