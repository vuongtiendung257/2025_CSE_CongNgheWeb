<?php

// Import Model
require_once 'models/SinhVienModel.php';

// kêt nối pdo
$host = '127.0.0.1';
$dbname = 'cse485_web';
$username = 'root';
$password = '';
$connString = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try 
{
    $pdo = new PDO($connString, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}

// TODO 8: Kiểm tra form thêm sinh viên
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ten_sinh_vien'])) 
{

    // TODO 9: Lấy dữ liệu từ form
    $tenSV = trim($_POST['ten_sinh_vien']);
    $emailSV = trim($_POST['email']);

    // TODO 10: Gọi hàm từ Model để thêm sinh viên
    addSinhVien($pdo, $tenSV, $emailSV);

    // TODO 11: Chuyển hướng để tránh thêm trùng khi F5
    header('Location: index.php');
    exit;
}

// TODO 12: Lấy danh sách sinh viên từ Model
$list_sv = getAllSinhVien($pdo);

// TODO 13: Gọi View để hiển thị
include 'views/sinhvien_view.php';
?>