<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="trang_chu.php">Trang Chủ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    Xin chào, <?php echo $_SESSION['full_name']; ?>

                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">Quản trị tài khoản</a>
                    <a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
</nav> -->
<link rel="stylesheet" href="css/navbar.css">
<nav class="navbar">
    <a class="navbar-brand" href="trang_chu.php">Trang Chủ</a>
    <ul class="navbar-nav">
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button">
                Xin chào, <?php echo $_SESSION['full_name']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Quản trị tài khoản</a><br><br>
                <a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a>
            </div>
        </li>
    </ul>
</nav>
