<?php

if (!isset($_SESSION['user_id'])) {
  
    header("Location: dang_nhap.php");
    exit();
}
?>

