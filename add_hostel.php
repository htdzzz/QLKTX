<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Thêm ký túc xá mới vào cơ sở dữ liệu
    $sql = "INSERT INTO hostels (name, address) VALUES ('$name', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "Ký túc xá đã được thêm thành công!";
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
    <title>Thêm ký túc xá</title>
</head>
<body>
    <h2>Thêm ký túc xá</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="name">Tên ký túc xá:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="address">Địa chỉ:</label><br>
        <input type="text" id="address" name="address" required><br><br>
        <input type="submit" value="Thêm ký túc xá">
    </form>
</body>
</html>
