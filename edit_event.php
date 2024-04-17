<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    // Truy vấn cơ sở dữ liệu để lấy thông tin sự kiện
    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = $conn->query($event_query);
    $event = $event_result->fetch_assoc();
} else {
    // Nếu không có ID sự kiện, chuyển hướng về trang quản lý sự kiện
    header("Location: quanlysukien.php");
    exit();
}

// Xử lý cập nhật thông tin sự kiện
if (isset($_POST['update'])) {
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    
    $update_query = "UPDATE events SET event_name = '$event_name', description = '$description', event_date = '$event_date' WHERE event_id = $event_id";
    
    if ($conn->query($update_query) === TRUE) {
        header("Location: quanlysukien.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sự kiện</title>
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
            height: 100px;
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
        <h2>Sửa sự kiện</h2>
        <form method="POST" action="" class="edit-form">
            <div class="form-group">
                <label for="event_name">Tên sự kiện:</label>
                <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" required><?php echo $event['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Ngày diễn ra:</label>
                <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
            </div>
            <button type="submit" class="btn" name="update">Cập nhật</button>
        </form>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="quanlysukien.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>

