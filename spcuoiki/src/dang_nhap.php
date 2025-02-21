<!DOCTYPE html>
<html lang="vi">

<?php
session_start();
include '../connectdb.php';
include '../function.php';

if (isset($_POST['btn_dang_nhap'])) {
    $tk = $_POST['username'];
    $mk = $_POST['password'];
    $mk = md5($mk);

    if (dang_nhap($tk, $mk) != 0) {
        // vào trang chủ
        $a = dang_nhap($tk, $mk);
        $_SESSION['full_name'] = $a['full_name'];
        $_SESSION['user_id'] = $a['user_id'];
        $_SESSION['role'] = $a['role'];
        
        
        header("location: trang_chu.php");
        exit;
    } else {
        // thông báo sai tài khoản
        echo "Thất bại";
    }
}





if (isset($_POST['btn_dangky'])) {

    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    $result = dang_ky($conn, $username, $full_name, $password, $confirm_password, $role);
 
    echo $result;
}


?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale =1">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dang_nhap.css">

    <title>Đăng Nhập</title>

</head>

<body>
    <div class="login">
        <span class="nuttat"><ion-icon name="close-outline"></ion-icon></span>
        <div class="site LOGIN">
            <form method="post">

                <h1>Đăng nhập</h1>
                <div class="input1">
                    <input type="text" name="username" placeholder="Tài khoản" id="acc" required>

                </div>

                <div class="input1">
                    <input type="password" name="password" placeholder="Mật khẩu" id="pass" required>

                </div>

                <div class="remember">
                    <label><input type="checkbox">Nhớ mật khẩu</label>
                    <a href="#">Quên mật khẩu?</a>
                </div>
                <button type="submit " class="nut1" id="nutdn" name="btn_dang_nhap">Đăng nhập</button>
                <div class="register">

                    <p>Không có tài khoản?<a href="#" class="register-link">Đăng ký</a></p>
                </div>

            </form>
        </div>


        <div class="site res">
            <form method="post">
                <h1>Đăng ký</h1>
                <div class="input1">
                    <input type="text" placeholder="Tài khoản" required id="tk" name="username">
                </div>
                <div class="input1">
                    <input type="text" placeholder="Họ và tên" required id="full_name" name="full_name">
                </div>
                <div class="input1">
                    <input type="password" placeholder="Mật khẩu" required id="mk" name="password">
                </div>
                <div class="input1">
                    <input type="password" placeholder="Nhập lại mật khẩu" required name="confirm_password">
                </div>
                <div>
                    <p>Chọn vai trò:</p>
                    <label><input type="radio" name="role" value="1"> Giáo viên</label>
                    <label><input type="radio" name="role" value="2"> Học sinh</label>
                    <label><input type="radio" name="role" value="0"> Admin</label>
                </div>
                <br>
                <div class="remember">
                    <label><input type="checkbox" required> Tôi chấp nhận các điều khoản</label>
                </div>
                <button type="submit" class="nut1" id="nutdk" name="btn_dangky">Đăng ký</button>
               
                <div class="register">
                    <p>Đã có tài khoản?<a href="#" class="login-link">Đăng nhập</a></p>
                </div>

            </form>
        </div>

    </div>
</body>
<script src="js/dang_nhap.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/9892708f88.js" crossorigin="anonymous"></script>

</html>