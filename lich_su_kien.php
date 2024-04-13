<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sự kiện và Hoạt động</title>
    <link rel="stylesheet" href="css/lich_su_kien.css">
</head>
<body>
    <div class="container">
        <h2>Lịch sự kiện và Hoạt động</h2>
        <ul>
            <?php
            // SQL query để lấy danh sách sự kiện
            $sql = "SELECT * FROM events";

            // Thực thi truy vấn
            $result = $conn->query($sql);

            // Kiểm tra nếu có kết quả trả về
            if ($result->num_rows > 0) {
                // Hiển thị thông tin của từng sự kiện
                while($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<strong>Sự kiện:</strong> " . $row["event_name"]. "<br>";
                    echo "<strong>Ngày diễn ra:</strong> " . $row["event_date"]. "<br>";
                    echo "<strong>Mô tả:</strong> " . $row["description"];
                    echo "</li>";
                }
            } else {
                echo "<li>Không tìm thấy sự kiện nào.</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
