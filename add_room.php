<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];

    // Thêm phòng mới vào cơ sở dữ liệu
    $sql = "INSERT INTO rooms (room_number, room_type) VALUES ('$room_number', '$room_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Phòng đã được thêm thành công!";
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
    <title>Thêm phòng</title>
</head>
<body>
    <h2>Thêm phòng</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="room_number">Số phòng:</label><br>
        <input type="text" id="room_number" name="room_number" required><br>
        <label for="room_type">Loại phòng:</label><br>
        <input type="text" id="room_type" name="room_type" required><br><br>
        <input type="submit" value="Thêm phòng">
    </form>
</body>
</html>
