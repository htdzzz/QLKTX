<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý yêu cầu tìm kiếm
if (isset($_GET['query'])) {
    $search_query = $_GET['query'];

    // Truy vấn cơ sở dữ liệu để tìm kiếm thông tin
    $search_students_query = "SELECT * FROM students WHERE name LIKE '%$search_query%'";
    $search_students_result = $conn->query($search_students_query);

    $search_rooms_query = "SELECT * FROM rooms WHERE room_number LIKE '%$search_query%'";
    $search_rooms_result = $conn->query($search_rooms_query);

    $search_hostels_query = "SELECT * FROM hostels WHERE name LIKE '%$search_query%'";
    $search_hostels_result = $conn->query($search_hostels_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative; /* Cần thiết để định vị nút đăng xuất */
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        /* Button style */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 5px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Table style */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Kết quả tìm kiếm</h2>

        <!-- Hiển thị kết quả tìm kiếm -->
        <div class="search-results">
            <?php if (isset($_GET['query'])): ?>
                <?php if ($search_students_result->num_rows > 0): ?>
                    <h3>Thông tin sinh viên:</h3>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                        </tr>
                        <?php while ($row = $search_students_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row["ID"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>Không có kết quả nào cho "Sinh viên" được tìm kiếm.</p>
                <?php endif; ?>

                <?php if ($search_rooms_result->num_rows > 0): ?>
                    <h3>Thông tin phòng:</h3>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Số phòng</th>
                            <th>Loại phòng</th>
                        </tr>
                        <?php while ($row = $search_rooms_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row["ID"]; ?></td>
                                <td><?php echo $row["room_number"]; ?></td>
                                <td><?php echo $row["room_type"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>Không có kết quả nào cho "Phòng" được tìm kiếm.</p>
                <?php endif; ?>

                <?php if ($search_hostels_result->num_rows > 0): ?>
                    <h3>Thông tin ký túc xá:</h3>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Địa chỉ</th>
                        </tr>
                        <?php while ($row = $search_hostels_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row["ID"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>Không có kết quả nào cho "Ký túc xá" được tìm kiếm.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>Vui lòng nhập từ khóa tìm kiếm.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
