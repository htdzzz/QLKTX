<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin sinh viên
$students_query = "SELECT * FROM students";
$students_result = $conn->query($students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sinh viên</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Thêm nút đăng xuất -->
        <form method="POST" action="">
            <button type="submit" name="logout" class="btn logout-button">Đăng xuất</button>
        </form>
        <h2>Thông tin sinh viên:</h2>
        <div class="button-container add-buttons">
            <a href="add_student.php" class="btn">Thêm sinh viên</a>
        </div>
        <?php if (isset($students_result) && $students_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $students_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['ID']; ?>" class="btn">Sửa</a>
                            <a href="delete_student.php?id=<?php echo $row['ID']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có sinh viên</p>
        <?php endif; ?>
    </div>
</body>
</html>
