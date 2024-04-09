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
        <form action="login_process.php" method="POST">
            <label for="username">Tên người dùng:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Đăng nhập">
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>.</p>
    </div>
</body>
</html>
