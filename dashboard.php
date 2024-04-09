<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin sinh viên, phòng và ký túc xá
$students_query = "SELECT * FROM students";
$students_result = $conn->query($students_query);

$rooms_query = "SELECT * FROM rooms";
$rooms_result = $conn->query($rooms_query);

$hostels_query = "SELECT * FROM hostels";
$hostels_result = $conn->query($hostels_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Ký Túc Xá</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn logout-button">Đăng xuất</a> <!-- Thêm nút đăng xuất -->
        <h2>Dashboard</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>

        <h3>Thông tin sinh viên:</h3>
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

        <h3>Thông tin phòng:</h3>
        <div class="button-container add-buttons">
            <a href="add_room.php" class="btn">Thêm phòng</a>
        </div>
        <?php if (isset($rooms_result) && $rooms_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Số phòng</th>
                    <th>Loại phòng</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $rooms_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td><?php echo $row["room_type"]; ?></td>
                        <td>
                            <a href="edit_room.php?id=<?php echo $row['ID']; ?>" class="btn">Sửa</a>
                            <a href="delete_room.php?id=<?php echo $row['ID']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có phòng</p>
        <?php endif; ?>

        <h3>Thông tin ký túc xá:</h3>
        <div class="button-container add-buttons">
            <a href="add_hostel.php" class="btn">Thêm ký túc xá</a>
        </div>
        <?php if (isset($hostels_result) && $hostels_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $hostels_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td>
                            <a href="edit_hostel.php?id=<?php echo $row['ID']; ?>" class="btn">Sửa</a>
                            <a href="delete_hostel.php?id=<?php echo $row['ID']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa ký túc xá này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có ký túc xá</p>
        <?php endif; ?>
    </div>
</body>
</html>
