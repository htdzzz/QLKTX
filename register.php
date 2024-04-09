<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h2>Đăng ký</h2>
        <form action="register_process.php" method="POST">
            <label for="username">Tên người dùng:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Nhập lại mật khẩu:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <input type="submit" value="Đăng ký">
        </form>
    </div>
</body>
</html>
