<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra nếu form đã được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $student_id = $_POST["student_id"];
    $service_id = $_POST["service_id"];
    $amount = $_POST["amount"];
    $payment_date = $_POST["payment_date"];

    // Thực hiện thêm dữ liệu vào cơ sở dữ liệu
    $add_payment_query = "INSERT INTO payments (student_id, service_id, amount, payment_date) VALUES ('$student_id', '$service_id', '$amount', '$payment_date')";
    if ($conn->query($add_payment_query) === TRUE) {
        header("Location: payment_management.php");
        exit();
    } else {
        echo "Error: " . $add_payment_query . "<br>" . $conn->error;
    }
}

// Truy vấn cơ sở dữ liệu để lấy danh sách sinh viên và dịch vụ
$students_query = "SELECT * FROM students";
$students_result = $conn->query($students_query);

$services_query = "SELECT * FROM services";
$services_result = $conn->query($services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thanh toán</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm thanh toán</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="payment-form">
            <div class="form-group">
                <label for="student_id">Sinh viên:</label>
                <select name="student_id" id="student_id">
                    <?php while ($student = $students_result->fetch_assoc()): ?>
                        <option value="<?php echo $student["student_id"]; ?>"><?php echo $student["full_name"]; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="service_id">Dịch vụ:</label>
                <select name="service_id" id="service_id">
                    <?php while ($service = $services_result->fetch_assoc()): ?>
                        <option value="<?php echo $service["service_id"]; ?>"><?php echo $service["service_name"]; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Số tiền:</label>
                <input type="text" name="amount" id="amount">
            </div>
            <div class="form-group">
                <label for="payment_date">Ngày thanh toán:</label>
                <input type="date" name="payment_date" id="payment_date">
            </div>
            <button type="submit" class="btn">Thêm thanh toán</button>
        </form>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="payment_management.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
