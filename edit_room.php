<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];

    $update_query = "UPDATE rooms SET room_number='$room_number', room_type='$room_type' WHERE ID=$id";
    
    if ($conn->query($update_query) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Lỗi: " . $update_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa phòng</title>
</head>
<body>
    <h2>Sửa phòng</h2>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $room_query = "SELECT * FROM rooms WHERE ID=$id";
        $result = $conn->query($room_query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
        <label for="room_number">Số phòng:</label><br>
        <input type="text" id="room_number" name="room_number" value="<?php echo $row['room_number']; ?>" required><br>
        <label for="room_type">Loại phòng:</label><br>
        <input type="text" id="room_type" name="room_type" value="<?php echo $row['room_type']; ?>" required><br><br>
        <input type="submit" value="Lưu">
    </form>
    <?php
        }
    }
    ?>
</body>
</html>
