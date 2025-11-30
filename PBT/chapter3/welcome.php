<?php
// TODO 1: Khởi động session
session_start();

// TODO 2: Kiểm tra tồn tại của session 'username'
if (isset($_SESSION['username'])) 
{

    // TODO 3: Lấy username từ SESSION
    $loggedInUser = $_SESSION['username'];

    // TODO 4: In ra lời chào mừng
    echo "<h1>Chào mừng trở lại, $loggedInUser!</h1>";
    echo "<p>Bạn đã đăng nhập thành công.</p>";

    // TODO 5: Link đăng xuất tạm thời (chỉ quay về login.html)
    echo '<a href="login.html">Đăng xuất (Tạm thời)</a>';

} 
else 
{

    // TODO 6: Không có SESSION → chuyển hướng về login 
    header('Location: login.html');
    exit;
}
?>
