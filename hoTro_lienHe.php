<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ trợ và Liên hệ</title>
    <style>
        body {
            background-image: url('css/bg1.jpg');
            background-size: cover; /* Đảm bảo hình nền được phủ toàn bộ kích thước của body */
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        p {
            margin: 10px 0;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hỗ trợ và Liên hệ</h2>
        <p>Chúng tôi rất vui lòng được hỗ trợ bạn. Vui lòng liên hệ qua thông tin dưới đây:</p>
        <ul>
            <li><strong>Địa chỉ:</strong> VQ4P+249, Phường Tân Phú, Quận 9, Thành phố Hồ Chí Minh</li>
            <li><strong>Điện thoại:</strong> 0123 456 789</li>
            <li><strong>Email:</strong> hoangtiendung68.68@gmail.com</li>
        </ul>
        <p>Nếu bạn có bất kỳ câu hỏi hoặc yêu cầu nào, xin vui lòng điền vào biểu mẫu sau:</p>
        <form method="POST">
            <label for="name">Họ và tên:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="message">Nội dung tin nhắn:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>
            <input type="submit" value="Gửi">
        </form>
    </div>
</body>
</html>
