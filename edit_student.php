<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý khi form được gửi đi
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update thông tin sinh viên vào cơ sở dữ liệu
    $sql = "UPDATE students SET name='$name', email='$email', phone='$phone' WHERE ID='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Thông tin sinh viên đã được cập nhật thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy thông tin sinh viên từ cơ sở dữ liệu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE ID='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    } else {
        echo "Không tìm thấy sinh viên có ID = " . $id;
        exit();
    }
} else {
    echo "Không có ID sinh viên được cung cấp!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sinh viên</title>
</head>
<body>
    <h2>Chỉnh sửa thông tin sinh viên</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Tên:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
        <label for="phone">Số điện thoại:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"><br><br>
        <input type="submit" value="Cập nhật">
    </form>
</body>
</html>
