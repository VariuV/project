<?php

include 'connectdb.php';


function registerUser($conn, $username, $full_name, $password, $confirm_password, $role)
{
    
    if ($password !== $confirm_password) {
        return "Mật khẩu không khớp. Vui lòng thử lại.";
    }
    $hashed_password = md5($password);
   
    // Câu lệnh SQL
    $sql = "INSERT INTO user (`username`, `password`, `role`, `full_name`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return "Lỗi trong prepare(): " . $conn->error;
    }

    // Gắn tham số
    $stmt->bind_param("ssis", $username, $hashed_password, $role, $full_name);

    // Thực thi truy vấn
    if ($stmt->execute()) {
        $stmt->close();
        return "Đăng ký thành công! ID tài khoản mới: " . $conn->insert_id . ", Vai trò: " . $role;
    } else {
        $stmt->close();
        return "Lỗi: " . $stmt->error;
    }
} 

function dang_nhap($tk, $mk)
{
    global $conn;
    $sql = "SELECT `user_id`, `username`, `password`, `role`, `full_name` FROM `user` WHERE `username` = '$tk' and `password`=  '$mk'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {
        return mysqli_fetch_array($kq);
    } else {
        return 0;
    }
}

function insertMajor($major_name, $subject_group, $start, $end)
{
    global $conn;
    $sql_insert = "INSERT INTO `major` (`major_name`, `start_date`, `end_date`, `id_subject_group`) VALUES ('$major_name', '$start', '$end', '$subject_group')";
    if (mysqli_query($conn, $sql_insert)) {
        return true;
    } else {
        return false;
    }
}

function createInput($type = "", $name = "", $value = "", $class = "")
{
    return "<input type='$type' name='$name' value='$value' class='$class'>";
}

// function printMajorData($i, $idMajor, $majorName, $subjectGroup, $startDate, $endDate)
// {
//     global $conn;
//     echo "<tr>";
//     echo "<td>" . $i++ . "</td>";
//     echo "<td>" . $majorName . "</td>";
//     echo "<td>" . $subjectGroup . "</td>";
//     echo "<td>" . $startDate . "</td>";
//     echo "<td>" . $endDate . "</td>";

//     // Display action buttons only for admins
//     if ($_SESSION['role'] == 0) {
//         echo "<td> 
//                 <form method='post' style='display:inline;'> 
//                     " . createInput("hidden", "id", $idMajor) . "
//                     " . createInput("submit", "delete", "Xóa") . "
//                     " . createInput("submit", "hidden", "Ẩn") . "
//                     " . createInput("submit", "show", "Hiện") . "
//                     <a href='suathongtin.php?id=$idMajor'>Chỉnh sửa</a>  
//                 </form> 
//               </td>";
//     } elseif ($_SESSION['role'] == 2) {
//         echo "<td><a href='nop_ho_so.php?id=$idMajor'>Nộp hồ sơ</a>
//             <a href='xem_ho_so.php?id=$idMajor'>Xem lại hồ sơ</a> </td>";   
    
//         }
//     echo "</tr>";
// }

function printMajorData($i, $idMajor, $majorName, $subjectGroup, $startDate, $endDate)
{
    global $conn;
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . $majorName . "</td>";
    echo "<td>" . $subjectGroup . "</td>";
    echo "<td>" . $startDate . "</td>";
    echo "<td>" . $endDate . "</td>";

    // Kiểm tra thời gian hiện tại
    $currentDate = date("Y-m-d H:i:s");  // Lấy thời gian hiện tại
    if ($currentDate < $startDate) {
        $status = "Chưa bắt đầu";
    } elseif ($currentDate > $endDate) {
        $status = "Đã kết thúc";
    } else {
        $status = "Đang mở";
    }

    // Hiển thị trạng thái nộp hồ sơ
    echo "<td>$status</td>";

    // Display action buttons only for admins
    if ($_SESSION['role'] == 0) {
        echo "<td> 
                <form method='post' style='display:inline;'> 
                    " . createInput("hidden", "id", $idMajor) . "
                    " . createInput("submit", "delete", "Xóa") . "
                    " . createInput("submit", "hidden", "Ẩn") . "
                    " . createInput("submit", "show", "Hiện") . "
                    <a href='suathongtin.php?id=$idMajor'>Chỉnh sửa</a>  
                </form> 
              </td>";
    } elseif ($_SESSION['role'] == 2) {
        // Kiểm tra nếu thời gian nộp hồ sơ đang mở
        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            echo "<td><a href='nop_ho_so.php?id=$idMajor'>Nộp hồ sơ</a>
            <a href='xem_ho_so.php?id=$idMajor'>Xem lại hồ sơ</a> </td>";   
        } else {
            echo "<td>Không thể nộp hồ sơ (Hạn chót)</td>";
        }
    }
    echo "</tr>";
}


// Handle form submissions for toggling visibility
function chucnangbang()
{
    global $conn;

    // Handle delete action
    if (isset($_POST['delete']) && $_SESSION['role'] == 0) {
        $id_to_delete = $_POST['id'];
        $sql_delete_major = "DELETE FROM `major` WHERE `id_major` = '$id_to_delete'";
        if (mysqli_query($conn,  $sql_delete_major)) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Lỗi khi xóa: " . mysqli_error($conn);
        }
    }

    // ẩn 
    if (isset($_POST['hidden']) && $_SESSION['role'] == 0) {
        $id_to_hide = $_POST['id'];
        $sql_update = "UPDATE `major` SET `hidden` = 1 WHERE `id_major` = '$id_to_hide'";
        mysqli_query($conn, $sql_update);
    }

    // hiện
    if (isset($_POST['show']) && $_SESSION['role'] == 0) {
        $id_to_show = $_POST['id'];
        $sql_update = "UPDATE `major` SET `hidden` = 0 WHERE `id_major` = '$id_to_show'";
        mysqli_query($conn, $sql_update);
    }
}


function laythongtin()
{
    $i = 1;
    global $conn;


    $sql = "SELECT m.id_major, m.major_name,m.start_date, m.end_date, sg.group_name 
            FROM major m
            JOIN subject_group sg ON m.id_subject_group = sg.id_subject_group
            WHERE sg.id_subject_group = m.id_subject_group ";
    if ($_SESSION['role'] != 0) {
        $sql .= "&& `hidden` = 0 ";
    }

    $kq = mysqli_query($conn, $sql);

    if ($kq && mysqli_num_rows($kq) > 0) {
        while ($row = mysqli_fetch_array($kq)) {
            printMajorData($i, $row["id_major"], $row["major_name"], $row["group_name"], $row["start_date"], $row["end_date"]);
            $i++;
        }
    } else {
        echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
    }
}


function suathongtin()
{
    global $conn;
    $id_major = $_GET['id'];

    $sql = "SELECT m.*,sg.group_name 
            FROM major m 
            JOIN subject_group sg ON m.id_subject_group = sg.id_subject_group 
            WHERE m.id_major = '$id_major'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_array($result);
    } else {
        return 0;
    }
}


function intengv()
{
    global $conn;
    $sql = "SELECT `user_id`, `full_name` FROM `user` WHERE `role` = 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($a = mysqli_fetch_array($result)) {
            echo "<option value='{$a['user_id']}'>{$a['full_name']}</option>";
        }
    }
}
function intennganh()
{
    global $conn;
    $sql = "SELECT `id_major`, `major_name` FROM `major` WHERE `hidden` = 0";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($a = mysqli_fetch_array($result)) {
            echo "<option value='{$a['id_major']}'>{$a['major_name']}</option>";
        }
    }
}


// function in_bang_phan_cong()
// {
//     global $conn;
//     // Lấy danh sách phân công giáo viên
//     $sql_list = "SELECT m.id_major, m.major_name, u.full_name
//                 FROM major m
//                 LEFT JOIN user u ON m.id_manager = u.user_id
//                 WHERE m.hidden = 0";
//     $result = mysqli_query($conn, $sql_list);
//     while ($row = mysqli_fetch_array($result)) {
//         echo "<tr>
//                <td>{$row['id_major']}</td>
//                <td>{$row['major_name']}</td>
//                <td>{$row['full_name']}</td>
//                <td><a href='#'>Chỉnh sửa</a></td> 
//              </tr>";
//     }
//     // thêm hàm xóa vào phần chỉnh sửa!!!
// }
function in_bang_phan_cong()
{
    global $conn;
    
    $sql_list = "SELECT m.id_major, m.major_name, u.full_name
                FROM major m
                LEFT JOIN user u ON m.id_manager = u.user_id
                WHERE m.hidden = 0";
    $result = mysqli_query($conn, $sql_list);
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
               <td>{$row['id_major']}</td>
               <td>{$row['major_name']}</td>
               <td>{$row['full_name']}</td>
               <td><a href='#' class='edit-link'>Chỉnh sửa</a></td> 
             </tr>";
    }
    
}

// function save_application() {
//     global $conn;

//     if (isset($_POST['submit_application'])) {
//         // Lấy thông tin từ form
//         $id_major = $_GET['id'];
//         $point1 = intval($_POST['score1']);
//         $point2 = intval($_POST['score2']);
//         $point3 = intval($_POST['score3']);
//         $submission_date = date('Y-m-d H:i:s');
//         $status = 0; // Mặc định 0 (chờ duyệt)
        
//         // Lưu thông tin vào bảng `applications`
//         $sql = "
//         INSERT INTO applications (status, submission_date, point1, point2, point3, id_major )
//         VALUES ('$status', '$submission_date', '$point1', '$point2', '$point3', $id_major)
//         ";

//         if (mysqli_query($conn, $sql)) {
//             echo "<h3 class='success-message'>Hồ sơ đã được nộp thành công!</h3>";
//         } else {
//             echo "<h3 class='error-message'>Lỗi khi lưu hồ sơ: " . mysqli_error($conn) . "</h3>";
//         }
//     }
// }
function save_application()
{
    global $conn;
    

    if (isset($_POST['submit_application'])) {
        // Lấy thông tin từ form
        $id_major = intval($_GET['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dob = $_POST['dob'];
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $id_card = mysqli_real_escape_string($conn, $_POST['id_card']);
        $submission_date = date('Y-m-d H:i:s');
        $status = 0; // Mặc định 0 (chờ duyệt)
        $student_id = $_SESSION['user_id'];
        // Xử lý các trường điểm
        $point1 = intval($_POST['score1']);
        $point2 = intval($_POST['score2']);
        $point3 = intval($_POST['score3']);
    
        // Xử lý file ảnh và file học bạ
        $photo_path = null;
        $transcript_path = null;
    
        if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != "") {
            $photo_path = 'uploads/' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }
    
        if (isset($_FILES['transcript']['name']) && $_FILES['transcript']['name'] != "") {
            $transcript_path = 'uploads/' . basename($_FILES['transcript']['name']);
            move_uploaded_file($_FILES['transcript']['tmp_name'], $transcript_path);
        }
    
        // Lưu thông tin vào bảng `applications`
        $sql = "
        INSERT INTO applications (status, submission_date, point1, point2, point3, id_major,student_id, name, dob, address, id_card, photo, transcript)
        VALUES ('$status', '$submission_date', '$point1', '$point2', '$point3', $id_major ,$student_id,'$name', '$dob', '$address', '$id_card', '$photo_path', '$transcript_path')
        ";
    
        // Kiểm tra và thông báo kết quả
        if (mysqli_query($conn, $sql)) {
            echo "<h3 class='success-message'>Hồ sơ đã được nộp thành công!</h3>";
        } else {
            echo "<h3 class='error-message'>Lỗi khi lưu hồ sơ: " . mysqli_error($conn) . "</h3>";
        }
    }
    
}



function in_ho_so()
{
    global $conn;

    // Lấy id_major từ tham số GET
    if (isset($_GET['id'])) {
        $id_major = $_GET['id'];
    } else {
        echo "Không tìm thấy thông tin ngành học.";
        return;
    }
    $sql_time_check = "SELECT start_date, end_date FROM major WHERE id_major = $id_major";
    $result_time_check = mysqli_query($conn, $sql_time_check);

    if (!$result_time_check || mysqli_num_rows($result_time_check) == 0) {
        echo "Không tìm thấy thông tin thời gian nộp hồ sơ cho ngành này.";
        return;
    }

    $row_time = mysqli_fetch_assoc($result_time_check);
    $start_date = $row_time['start_date'];
    $end_date = $row_time['end_date'];

    $current_date = date("Y-m-d H:i:s");

    // Kiểm tra xem thời gian nộp hồ sơ có hợp lệ không
    if ($current_date < $start_date) {
        echo "<p class='error'>Chưa đến thời gian nộp hồ sơ cho ngành này.</p>";
        return;
    } elseif ($current_date > $end_date) {
        echo "<p class='error'>Hạn chót nộp hồ sơ đã qua.</p>";
        return;
    }

    if (isset($_SESSION['user_id'])) {
        $student_id = $_SESSION['user_id'];

        // Truy vấn kiểm tra xem sinh viên đã nộp hồ sơ cho ngành này chưa
        $sql_check = "SELECT app_id FROM applications WHERE student_id = $student_id AND id_major = $id_major";
        $result_check = mysqli_query($conn, $sql_check);

        if (!$result_check) {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            return;
        }

        $applications = [];
        while ($row_check = mysqli_fetch_assoc($result_check)) {
            $applications[] = $row_check['app_id'];
        }

        if (count($applications) > 1) {
            echo'<a href="trang_chu.php" class=" return">Trở về </a>';
            // Xóa các bản ghi dư thừa, chỉ giữ lại bản ghi đầu tiên
            $ids_to_delete = array_slice($applications, 1); // Lấy tất cả ID trừ bản ghi đầu tiên
            $ids_to_delete_str = implode(',', $ids_to_delete);

            $sql_delete = "DELETE FROM applications WHERE app_id IN ($ids_to_delete_str)";
            mysqli_query($conn, $sql_delete);

            // Thông báo lỗi và kết thúc
            echo "<p class='error'>Bạn đã nộp hồ sơ cho ngành này rồi. Mỗi sinh viên chỉ được nộp một hồ sơ cho mỗi ngành.</p>";
            return;
        }
    } else {
        echo "Vui lòng đăng nhập để nộp hồ sơ!";
        return;
    }


    // Truy vấn thông tin ngành học và tổ hợp môn
    $sql = "SELECT sg.subject, m.major_name , sg.group_name
            FROM major m
            JOIN subject_group sg ON m.id_subject_group = sg.id_subject_group
            WHERE m.id_major = $id_major";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra kết quả truy vấn
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Không tìm thấy thông tin ngành học.";
        return;
    }

    // Hiển thị thông tin form
    while ($row = mysqli_fetch_array($result)) {
        echo "<h2 class='form-heading'>Nộp hồ sơ cho ngành {$row['major_name']}</h2>";
        
        // Trường nhập họ tên
        echo '<label for="name" class="label-field">Họ và tên:</label>';
        echo '<input type="text" name="name" id="name" class="input-field" placeholder="Nhập họ và tên" required><br>';

        echo '<label for="dob" class="label-field">Ngày sinh:</label>';
        echo '<input type="date" name="dob" id="dob" class="input-field" required><br>';

        echo '<label for="address" class="label-field">Nơi sinh sống:</label>';
        echo '<input type="text" name="address" id="address" class="input-field" placeholder="Nhập nơi sinh sống" required><br>';

        echo '<label for="id_card" class="label-field">Căn cước công dân:</label>';
        echo '<input type="text" name="id_card" id="id_card" class="input-field" placeholder="Nhập số căn cước công dân" required><br>';

        echo '<label for="photo" class="label-field">Ảnh cá nhân:</label>';
        echo '<input type="file" name="photo" id="photo" class="file-input" accept="image/*" required><br>';

        echo '<label for="transcript" class="label-field">File học bạ:</label>';
        echo '<input type="file" name="transcript" id="transcript" class="file-input" accept=".pdf,.doc,.docx" required><br>';

        // Các trường nhập điểm theo tổ hợp môn
        $subjects = explode(',', $row['subject']);
        $i = 1;
        foreach ($subjects as $subject) {
            echo '<label for="score' . $i . '" class="label-subject">' . $subject . ':</label>';
            echo '<input type="text" name="score' . $i . '" id="score' . $i . '" class="input-score" placeholder="Nhập điểm ' . $subject . '" required><br>';
            $i++;
        }
        echo '<button type="submit" name="submit_application" class="btn-submit">Nộp hồ sơ</button>';
    }
}


// function get_applications_for_teacher()
// {
//     global $conn;

//     // Giáo viên hiện tại (lấy từ session)
//     $teacher_id =  $_SESSION['user_id'];
//     $idMajor = $_SESSION['id_major'];

//     // Truy vấn lấy hồ sơ thuộc ngành mà giáo viên phụ trách
//     $sql = "
//     SELECT 
//         a.app_id, 
//         a.status, 
//         a.submission_date, 
//         a.point1, 
//         a.point2, 
//         a.point3, 
//         a.img, 
        
//         m.major_name
//     FROM 
//         applications a
//     JOIN 
//         major m ON a.id_major = m.id_major
//     JOIN 
//         user u ON m.id_manager = u.user_id
//     WHERE 
//         u.user_id = $teacher_id
        
//     ";

//     $result = mysqli_query($conn, $sql);

//     if ($result && mysqli_num_rows($result) > 0) {
//         echo "<h2>Danh sách hồ sơ được phân công</h2>";
//         echo "<table border='1'>";
//         echo "<tr>
//                 <th>ID</th>
//                 <th>Ngành</th>
//                 <th>Điểm 1</th>
//                 <th>Điểm 2</th>
//                 <th>Điểm 3</th>
//                 <th>Ngày nộp</th>
//                 <th>Trạng thái</th>
//                 <th>Học bạ</th>
//               </tr>";

//         while ($row = mysqli_fetch_assoc($result)) {
//             $status_text = $row['status'] == 0 ? 'Chờ duyệt' : ($row['status'] == 1 ? 'Đã duyệt' : 'Từ chối');
//             echo "<tr>
//                     <td>{$row['app_id']}</td>
//                     <td>{$row['major_name']}</td>
//                     <td>{$row['point1']}</td>
//                     <td>{$row['point2']}</td>
//                     <td>{$row['point3']}</td>
//                     <td>{$row['submission_date']}</td>
//                     <td>{$status_text}</td>
//                     <td><a href='xem_ho_so.php?id=$idMajor>Xem Hồ Sơ</a></td>
//                   </tr>";
//         }

//         echo "</table>";
//     } else {
//         echo "<h3>Không có hồ sơ nào được phân công.</h3>";
       
//     }
// }
function get_applications_for_teacher()
{
    global $conn;

    // Giáo viên hiện tại (lấy từ session)
    $teacher_id = $_SESSION['user_id'];

    // Truy vấn lấy hồ sơ thuộc ngành mà giáo viên phụ trách
    $sql = "
    SELECT 
        a.app_id, 
        a.status, 
        a.submission_date, 
        a.point1, 
        a.point2, 
        a.point3, 
        a.img, 
        m.major_name
    FROM 
        applications a
    JOIN 
        major m ON a.id_major = m.id_major
    JOIN 
        user u ON m.id_manager = u.user_id
    WHERE 
        u.user_id = $teacher_id
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Danh sách hồ sơ được phân công</h2>";
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Ngành</th>
                <th>Điểm 1</th>
                <th>Điểm 2</th>
                <th>Điểm 3</th>
                <th>Ngày nộp</th>
                <th>Trạng thái</th>
                <th>Học bạ</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $status_text = $row['status'] == 0 ? 'Chờ duyệt' : ($row['status'] == 1 ? 'Đã duyệt' : 'Từ chối');
            echo "<tr>
                    <td>{$row['app_id']}</td>
                    <td>{$row['major_name']}</td>
                    <td>{$row['point1']}</td>
                    <td>{$row['point2']}</td>
                    <td>{$row['point3']}</td>
                    <td>{$row['submission_date']}</td>
                    <td>{$status_text}</td>
                    <td><a href='xem_ho_so.php?id={$row['app_id']}'>Xem Hồ Sơ</a></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<h3>Không có hồ sơ nào được phân công.</h3>";
    }
}




function displayApplications($idMajor)
{
    global $conn;

    $query = "SELECT * FROM applications WHERE id_major = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idMajor);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='container'>";
    echo "<h3>Danh sách hồ sơ đã nộp</h3>";
    echo "<table>";
    echo "<tr>
            <th>STT</th>
            <th>Mã hồ sơ</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>CMND/CCCD</th>
            <th>Trạng thái</th>
            <th>Ngày nộp</th>
            <th>Điểm môn 1</th>
            <th>Điểm môn 2</th>
            <th>Điểm môn 3</th>
            <th>Ảnh</th>
            <th>Học bạ</th>
          </tr>";

    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $row['app_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['id_card']) . "</td>";
        echo "<td>" . ($row['status'] == 1 ? "Đã duyệt" : "Chưa duyệt") . "</td>";
        echo "<td>" . $row['submission_date'] . "</td>";
        echo "<td>" . $row['point1'] . "</td>";
        echo "<td>" . $row['point2'] . "</td>";
        echo "<td>" . $row['point3'] . "</td>";
        echo "<td><img src='" . $row['photo'] . "' alt='Ảnh' width='100'></td>";
        echo "<td><a href='" . $row['transcript'] . "' target='_blank'>Xem</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";




    $stmt->close();
}
function gv_hs(){
    


// Lấy app_id từ URL
if (isset($_GET['id'])) {
    $app_id = $_GET['id'];

    global $conn;
    
    // Truy vấn lấy thông tin chi tiết của hồ sơ
    $sql = "
    SELECT 
        a.app_id, 
        a.status, 
        a.submission_date, 
        a.point1, 
        a.point2, 
        a.point3, 
        a.img, 
        a.address, 
        a.id_card, 
        a.name, 
        a.dob, 
        a.photo, 
        a.transcript, 
        m.major_name
    FROM 
        applications a
    JOIN 
        major m ON a.id_major = m.id_major
    WHERE 
        a.app_id = $app_id
    ";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Hiển thị thông tin chi tiết của hồ sơ
        echo "<div class='details-header'>";
        echo "<h2>Chi tiết hồ sơ: {$row['app_id']}</h2>";
        echo "<p>Ngành: " . htmlspecialchars($row['major_name']) . "</p>";
        echo "</div>";

        echo "<table class='details-table'>";
        echo "<tr><th>Tên</th><td>" . htmlspecialchars($row['name']) . "</td></tr>";
        echo "<tr><th>Ngày sinh</th><td>" . htmlspecialchars($row['dob']) . "</td></tr>";
        echo "<tr><th>Địa chỉ</th><td>" . htmlspecialchars($row['address']) . "</td></tr>";
        echo "<tr><th>CMND/CCCD</th><td>" . htmlspecialchars($row['id_card']) . "</td></tr>";
        echo "<tr><th>Điểm môn 1</th><td>" . $row['point1'] . "</td></tr>";
        echo "<tr><th>Điểm môn 2</th><td>" . $row['point2'] . "</td></tr>";
        echo "<tr><th>Điểm môn 3</th><td>" . $row['point3'] . "</td></tr>";
        echo "<tr><th>Ngày nộp</th><td>" . $row['submission_date'] . "</td></tr>";
        echo "<tr><th>Trạng thái</th><td>" . ($row['status'] == 0 ? 'Chờ duyệt' : ($row['status'] == 1 ? 'Đã duyệt' : 'Từ chối')) . "</td></tr>";
        echo "<tr><th>Ảnh</th><td><img src='" . htmlspecialchars($row['photo']) . "' width='100'></td></tr>";
        echo "<tr><th>Học bạ</th><td><a href='" . htmlspecialchars($row['transcript']) . "' target='_blank'>Xem học bạ</a></td></tr>";
        echo "</table>";

        // Nút quay lại
        echo "<a href='javascript:history.back()' class='back-button'>Quay lại</a>";
    } else {
        echo "<h3>Không tìm thấy hồ sơ này.</h3>";
    }
}

}


function get_all_applications_for_admin() {
    global $conn;

    // Truy vấn lấy tất cả hồ sơ từ mọi ngành
    $sql = "
    SELECT 
        a.app_id, 
        m.major_name
    FROM 
        applications a
    JOIN 
        major m ON a.id_major = m.id_major
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Danh sách toàn bộ hồ sơ</h2>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Ngành</th>
                <th>Các Hồ sơ</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['major_name']) . "</td>
                    <td><a href='xem_ho_so.php?id={$row['app_id']}'>Xem Hồ Sơ</a></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<h3>Không có hồ sơ nào trong hệ thống.</h3>";
    }
}

function admin_hs(){
    if (isset($_GET['id'])) {
        $app_id = $_GET['id'];
    
        global $conn;
        
        // Truy vấn lấy thông tin chi tiết của hồ sơ
        $sql = "
        SELECT 
            a.app_id, 
            a.status, 
            a.submission_date, 
            a.point1, 
            a.point2, 
            a.point3, 
            a.img, 
            a.address, 
            a.id_card, 
            a.name, 
            a.dob, 
            a.photo, 
            a.transcript, 
            m.major_name
        FROM 
            applications a
        JOIN 
            major m ON a.id_major = m.id_major
        WHERE 
            a.app_id = $app_id
        ";
    
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    
            // Hiển thị thông tin chi tiết của hồ sơ
           echo"<div class='container'>";
           echo "<div class='details-header'>";
           echo "<h2>Chi tiết hồ sơ: {$row['app_id']}</h2>";
           echo "<p>Ngành: " . htmlspecialchars($row['major_name']) . "</p>";
           echo "</div>";
   
           echo "<table class='details-table'>";
           echo "<tr><th>Tên</th><td>" . htmlspecialchars($row['name']) . "</td></tr>";
           echo "<tr><th>Ngày sinh</th><td>" . htmlspecialchars($row['dob']) . "</td></tr>";
           echo "<tr><th>Địa chỉ</th><td>" . htmlspecialchars($row['address']) . "</td></tr>";
           echo "<tr><th>CMND/CCCD</th><td>" . htmlspecialchars($row['id_card']) . "</td></tr>";
           echo "<tr><th>Điểm môn 1</th><td>" . $row['point1'] . "</td></tr>";
           echo "<tr><th>Điểm môn 2</th><td>" . $row['point2'] . "</td></tr>";
           echo "<tr><th>Điểm môn 3</th><td>" . $row['point3'] . "</td></tr>";
           echo "<tr><th>Ngày nộp</th><td>" . $row['submission_date'] . "</td></tr>";
           echo "<tr><th>Trạng thái</th><td>" . ($row['status'] == 0 ? 'Chờ duyệt' : ($row['status'] == 1 ? 'Đã duyệt' : 'Từ chối')) . "</td></tr>";
           echo "<tr><th>Ảnh</th><td><img src='" . htmlspecialchars($row['photo']) . "' width='100'></td></tr>";
           echo "<tr><th>Học bạ</th><td><a href='" . htmlspecialchars($row['transcript']) . "' target='_blank'>Xem học bạ</a></td></tr>";
           echo "</table>";

           // Nút duyệt hồ sơ
           if ($row['status'] == 0) { // Nếu hồ sơ đang chờ duyệt
               echo "<a href='?action=approve&id={$row['app_id']}' class='approve-button'>Duyệt Hồ Sơ</a> <br><br>";
           }

           // Nút xóa hồ sơ
           echo "<a href='?action=delete&id={$row['app_id']}' class='delete-button' onclick='return confirm(\"Bạn có chắc muốn xóa hồ sơ này không?\")'>Xóa Hồ Sơ</a>";

           // Nút quay lại
           echo "<a href='javascript:history.back()' class='back-button'>Quay lại</a>";
       } else {
           echo "<h3>Không tìm thấy hồ sơ này.</h3>";
       }

        echo "</div>"; }
        else {
            echo "<h3>Không tìm thấy hồ sơ này.</h3>";
        }
    }
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $app_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        if ($action == 'approve' && $app_id) {
            // Duyệt hồ sơ
            $query = "UPDATE applications SET status = 1 WHERE app_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $app_id);
            if ($stmt->execute()) {
                echo "<p>Hồ sơ $app_id đã được duyệt thành công.</p>";
            } else {
                echo "<p>Đã xảy ra lỗi khi duyệt hồ sơ.</p>";
            }
            $stmt->close();
            echo "<a href='javascript:history.back()'>Quay lại</a>";
        }
    
        elseif ($action == 'delete' && $app_id) {
            // Xóa hồ sơ
            $query = "DELETE FROM applications WHERE app_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $app_id);
            if ($stmt->execute()) {
                echo "<p>Hồ sơ $app_id đã được xóa thành công.</p>";
            } else {
                echo "<p>Đã xảy ra lỗi khi xóa hồ sơ.</p>";
            }
            $stmt->close();
            echo "<a href='javascript:history.back()'>Quay lại</a>";
        }
    }
    




    
