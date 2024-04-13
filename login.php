<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['user_id']; // Lưu user_id vào session
        $_SESSION['role'] = $row['role']; // Lưu vai trò của người dùng vào session
        if ($_SESSION['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: menu_user.php");
        }
    } else {
        // Đăng nhập thất bại
        $error = "Tên người dùng hoặc mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h2>ĐĂNG NHẬP</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username">Tên người dùng:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Đăng nhập">
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>.</p>
    </div>
</body>
</html>
