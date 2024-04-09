<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản Lý Ký Túc Xá</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn logout-button">Đăng xuất</a> <!-- Thêm nút đăng xuất -->
        <h2>Dashboard</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <!-- Nút chuyển qua trang thông tin sinh viên -->
        <div class="button-container">
            <a href="thongtinsv.php" class="btn">
                <img src="images/man.jpg" alt="Thông tin sinh viên" width="50" height="50">
                <span>Thông tin sinh viên</span> <!-- Đặt chữ ở dưới ảnh -->
            </a>
        </div>

        <!-- Nút chuyển qua trang thông tin phòng -->
        <div class="button-container">
            <a href="thongtinphong.php" class="btn">
                <img src="images/man.jpg" alt="Thông tin phòng" width="50" height="50">
                <span>Thông tin phòng</span>
            </a>
        </div>

        <!-- Nút chuyển qua trang thông tin ký túc xá -->
        <div class="button-container">
            <a href="thongtinktx.php" class="btn">
                <img src="images/man.jpg" alt="Thông tin ký túc xá" width="50" height="50">
                <span>Thông tin ký túc xá</span>
            </a>
        </div>
    </div>
</body>
</html>
