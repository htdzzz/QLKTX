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

