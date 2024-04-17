<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_service'])) {
        // Xử lý sửa thông tin dịch vụ
        $service_id = $_POST['service_id'];
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        $sql = "UPDATE services SET service_name='$service_name', price='$price', status='$status' WHERE service_id='$service_id'";

        if ($conn->query($sql) === TRUE) {
            // Thành công
            header("Location: dichvu_tienich.php");
            exit();
        } else {
            // Lỗi
            echo "Lỗi: " . $conn->error;
        }
    }
}

// Lấy service_id từ biến GET
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết của dịch vụ
    $service_query = "SELECT * FROM services WHERE service_id='$service_id'";
    $service_result = $conn->query($service_query);

    if ($service_result->num_rows > 0) {
        $service_row = $service_result->fetch_assoc();
        $service_name = $service_row['service_name'];
        $price = $service_row['price'];
        $status = $service_row['status'];
    } else {
        echo "Không tìm thấy dịch vụ.";
        exit();
    }
} else {
    echo "Không có ID dịch vụ được cung cấp.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin dịch vụ</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="css/edit_service.css">
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
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        .back-button {
            background-color: #bbb;
        }

        .back-button:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Sửa thông tin dịch vụ</h2>
        <!-- Form sửa dịch vụ -->
        <form action="" method="post">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
            <label for="service_name">Tên Dịch vụ:</label><br>
            <input type="text" id="service_name" name="service_name" value="<?php echo $service_name; ?>" required><br>
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" value="<?php echo $price; ?>" required><br>
            <label for="status">Trạng thái:</label><br>
            <select id="status" name="status">
                <option value="active" <?php if($status == 'active') echo 'selected'; ?>>Hoạt động</option>
                <option value="inactive" <?php if($status == 'inactive') echo 'selected'; ?>>Ngừng hoạt động</option>
            </select><br><br>
            <button type="submit" name="edit_service" class="btn">Lưu</button>
            <a href="dichvu_tienich.php" class="btn back-button">Trở về</a>
        </form>
    </div>
</body>
</html>

