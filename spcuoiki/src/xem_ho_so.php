<?php
session_start();
include 'nav.php';
include '../connectdb.php';
include '../function.php';
include 'check_login.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idMajor = intval($_GET['id']);
} else {
    echo "<h3>Lỗi: Không có id_major trong URL</h3>";
    exit;
}

?>



<!DOCTYPE html>

<head>
<link rel="stylesheet" href="css/xem_ho_so.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách hồ sơ</title>
</head>
<style>
    
</style>
<body>
    <h1>Danh sách hồ sơ đã nộp</h1>
    <?php 
    
    if ($_SESSION['role'] == 0){

        admin_hs();
    }
            
    
?>

    <?php 
    
    if ($_SESSION['role'] == 1){

         gv_hs();
    }
            
    
?>

<?php 
    if($_SESSION['role'] == 2){
    displayApplications($idMajor); }
    ?>
</body>
</html>

