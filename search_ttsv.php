<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem có dữ liệu được gửi từ form không
if (isset($_GET['query'])) {
    // Lấy từ khóa tìm kiếm từ form
    $search_query = $_GET['query'];

    // Truy vấn cơ sở dữ liệu để tìm kiếm thông tin sinh viên
    $search_query = $conn->real_escape_string($search_query);
    $search_query = '%' . $search_query . '%'; // Thêm dấu % cho phần tìm kiếm phù hợp
    $search_students_query = "SELECT students.student_id, students.full_name, students.email, students.phone_number, IFNULL(rooms.room_number, 'NULL') AS room_number FROM students LEFT JOIN rooms ON students.room_id = rooms.room_id WHERE students.full_name LIKE '$search_query' OR students.email LIKE '$search_query' OR students.phone_number LIKE '$search_query' OR rooms.room_number LIKE '$search_query'";
    $search_students_result = $conn->query($search_students_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - Thông tin Sinh viên</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <!-- Thêm nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Kết quả tìm kiếm:</h2>
        <?php if (isset($search_students_result) && $search_students_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Số phòng</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $search_students_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["student_id"]; ?></td>
                        <td><?php echo $row["full_name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["phone_number"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['student_id']; ?>" class="btn">Sửa</a>
                            <a href="delete_student.php?id=<?php echo $row['student_id']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="thongtinsv.php" class="btn">Trở về</a>
            </div>
        <?php else: ?>
            <p>Không có kết quả phù hợp</p>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="thongtinsv.php" class="btn">Trở về</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
