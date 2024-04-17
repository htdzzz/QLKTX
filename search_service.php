<?php
session_start();
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$query = "";
$services = [];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    // Get the search query
    $query = $_GET['query'];

    // Prepare and execute the SQL query to search for services by name
    $search_query = "SELECT * FROM services WHERE service_name LIKE '%$query%'";
    $search_result = $conn->query($search_query);

    // Check if there are any results
    if ($search_result->num_rows > 0) {
        // Fetch the results into an array
        while ($row = $search_result->fetch_assoc()) {
            $services[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Services</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- User info and logout button -->
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        
        <!-- Search form -->
        <h2>Tìm kiếm Dịch vụ</h2>
        <form method="GET" action="search_service.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm" value="<?php echo $query; ?>">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        
        <!-- Display search results -->
        <h3>Kết quả tìm kiếm:</h3>
        <?php if (empty($services)): ?>
            <p>Không tìm thấy dịch vụ nào.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên Dịch vụ</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                </tr>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo $service["service_id"]; ?></td>
                        <td><?php echo $service["service_name"]; ?></td>
                        <td><?php echo $service["price"]; ?></td>
                        <td><?php echo ($service["status"] == 'active') ? 'Hoạt động' : 'Ngừng hoạt động'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        
        <!-- Back button -->
        <div class="button-container add-buttons">
            <a href="dashboard.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
