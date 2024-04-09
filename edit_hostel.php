<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Cập nhật thông tin ký túc xá trong cơ sở dữ liệu
    $sql = "UPDATE hostels SET name='$name', address='$address' WHERE ID='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Thông tin ký túc xá đã được cập nhật thành công!";
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
    <title>Sửa ký túc xá</title>
</head>
<body>
    <h2>Sửa ký túc xá</h2>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Truy vấn thông tin ký túc xá từ cơ sở dữ liệu
        $sql = "SELECT * FROM hostels WHERE ID='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                <label for="name">Tên ký túc xá:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
                <label for="address">Địa chỉ:</label><br>
                <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required><br><br>
                <input type="submit" value="Cập nhật">
            </form>
            <?php
        } else {
            echo "Không tìm thấy ký túc xá có ID: $id";
        }
    } else {
        echo "Không có ID ký túc xá được cung cấp!";
    }
    ?>
</body>
</html>
