<?php

// kết nối pdo 
$server = '127.0.0.1';      // Địa chỉ máy chủ MySQL
$db = 'cse485_web';         // Tên database
$user = 'root';             // Username MySQL
$pass = '';                 // Password (mặc định XAMPP là rỗng)
$connString = "mysql:host=$server;dbname=$db;charset=utf8mb4";

try 
{
    // TODO 1: Tạo đối tượng PDO để kết nối CSDL
    $dbCon = new PDO($connString, $user, $pass);
    $dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $err) 
{
    die("Lỗi kết nối: " . $err->getMessage());
}

// TODO 2: Kiểm tr xem form được gửi đi chưa và đã có 'ten_sinh_vien' chưa 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ten_sinh_vien'])) 
{
    // TODO 3: Lấy dữ liệu từ form
    $tenSV = trim($_POST['ten_sinh_vien']);
    $emailSV = trim($_POST['email']);

    // TODO 4: Viết câu lệnh sql insert với prepared statement
    $sqlInsert = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";

    // TODO 5: Chuẩn bị và thực thi câu lệnh
    $stmtInsert = $dbCon->prepare($sqlInsert);
    $stmtInsert->execute([$tenSV, $emailSV]);

    // TODO 6: Chuyển hướng để tránh submit lại form
    header('Location: chapter4.php');
    exit;
}

// Lấy danh sách sinh viên (select)
$sqlSelect = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";
$stmtSelect = $dbCon->query($sqlSelect);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên - CSE485</title>
    <style>
        body 
        { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f9f9f9; 
        }
        h2 
        { 
            color: #005566; 
            text-align: center; 
        }
        .form-container 
        {
            max-width: 600px; 
            margin: auto; 
            padding: 15px; 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        input[type="text"], input[type="email"] 
        { 
            width: 100%; 
            padding: 8px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        button 
        { 
            background: #005566; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        button:hover 
        { 
            background: #007777; 
        }
        table 
        { 
            width: 80%; 
            margin: 20px auto; 
            border-collapse: collapse; 
            background: white; 
        }
        th, td 
        { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th 
        { 
            background: #e6f0fa; 
            color: #333; 
        }
        tr:nth-child(even) 
        { 
            background: #f9f9f9; 
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Thêm Sinh Viên Mới</h2>
    <form action="chapter4.php" method="POST">
        <label>Tên sinh viên:</label>
        <input type="text" name="ten_sinh_vien" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Thêm Sinh Viên</button>
    </form>
</div>

<h2>Danh Sách Sinh Viên</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Tên Sinh Viên</th>
        <th>Email</th>
        <th>Ngày Tạo</th>
    </tr>
   
   <?php
$allStudents = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

if (!empty($allStudents)) 
{
    foreach ($allStudents as $sv) : ?>
        <tr>
            <td><?php htmlspecialchars($sv['id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['ten_sinh_vien'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['ngay_tao'], ENT_QUOTES) ?></td>
        </tr>
    <?php endforeach;
}
?>
</table>

</body>
</html>