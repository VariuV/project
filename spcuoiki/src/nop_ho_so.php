<?php
session_start();
include 'nav.php';
include '../connectdb.php';
include '../function.php';
include 'check_login.php';




save_application();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/nop_ho_so.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp Hồ Sơ</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="application-form">
            <?php in_ho_so(); ?>
            <!-- <button type="submit" name="submit_application" class="btn-submit">Nộp hồ sơ</button> -->
        </form>
    </div>

</body>
</html>

