<?php

// $ps :: prepared statement
// query: truy vấn trực tiếp 
// execute: thực thi câu lệnh với giá trị truyền vào 

// TODO 1: Hàm lấy tất cả sinh viên
function getAllSinhVien($pdo) 
{
    $sql = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";
    $ps = $pdo->query($sql);
    return $ps->fetchAll(PDO::FETCH_ASSOC);
}

// TODO 2: Hàm thêm sinh viên mới
function addSinhVien($pdo, $tenSV, $emailSV) 
{
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $ps = $pdo->prepare($sql);
    $ps->execute([$tenSV, $emailSV]);
}
?>