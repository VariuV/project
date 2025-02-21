<?php
// hủy phiên, điều hướng về trang đăng nhập
session_start();
session_destroy();
header('location: dang_nhap.php');
?>