<?php
// Khởi động session
session_start();

// Danh sách tài khoản hợp lệ (username => password)
$accounts = [
    'admin' => '12345',
    'sa' => 'quyvuong25',
    '0963827847' => 'dung1'
];

// Kiểm tra xem form đã gửi chưa
if (isset($_POST['username']) && isset($_POST['password'])) 
{

    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Kiểm tra đăng nhập
    if (isset($accounts[$user]) && $accounts[$user] === $pass) 
    {
        // Lưu username vào SESSION
        $_SESSION['username'] = $user;

        // Chuyển hướng sang trang chào mừng
        header('Location: welcome.php');
        exit;
    }
    else 
    {
        // Sai thông tin → quay lại login với thông báo lỗi
        header('Location: login.html?error=1');
        exit;
    }

} 
else 
{
    // Truy cập trực tiếp file → đá về login
    header('Location: login.html');
    exit;
}
?>
