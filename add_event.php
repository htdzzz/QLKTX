<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý dữ liệu khi người dùng nhấn nút "Thêm sự kiện"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    // Chuẩn bị câu lệnh SQL để thêm sự kiện vào cơ sở dữ liệu
    $add_event_query = "INSERT INTO events (event_name, description, event_date) VALUES ('$event_name', '$description', '$event_date')";

    // Thực thi câu lệnh SQL
    if ($conn->query($add_event_query) === TRUE) {
        echo "Thêm sự kiện thành công!";
    } else {
        echo "Lỗi: " . $add_event_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sự kiện</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"],
        .btn {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover,
        .btn:hover {
            background-color: #45a049;
        }

        .btn.logout-button {
            background-color: #f44336;
            margin-right: 10px;
        }

        .btn.logout-button:hover {
            background-color: #d32f2f;
        }

        .button-container {
            text-align: center;
        }
    </style>
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
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm sự kiện</h2>
        <!-- Form thêm sự kiện -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="add-form">
            <div class="form-group">
                <label for="event_name">Tên sự kiện:</label>
                <input type="text" id="event_name" name="event_name" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Ngày diễn ra:</label>
                <input type="date" id="event_date" name="event_date" required>
            </div>
            <button type="submit" class="btn">Thêm sự kiện</button>
        </form>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="quanlysukien.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
