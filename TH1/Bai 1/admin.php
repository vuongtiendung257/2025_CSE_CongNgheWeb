<?php
require 'data_flower.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản trị - Danh sách hoa</title>
    <link rel="icon" type="image/png" href="images/fav.png">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th 
        { 
            background: #f06292; color: white; }
        img { width: 120px; border-radius: 6px; }
        .action-btn {
            padding: 5px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 4px;
        }
        .edit { background: #2196F3; color: white; }
        .delete { background: #e91e63; color: white; }
        .add { background: #4CAF50; color: white; margin-bottom: 15px; }
    </style>
</head>

<body>

<h1>🌼 Bảng quản trị các loài hoa</h1>

<button class="action-btn add">+ Thêm hoa mới</button>


<table>
    <tr>
        <th>#</th>
        <th>Tên hoa</th>
        <th>Mô tả</th>
        <th>Ảnh</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($flowers as $index => $f): ?>
    <tr>
        <td><?= $index + 1 ?></td>
        <td><?= $f["name"] ?></td>
        <td><?= $f["description"] ?></td>
        <td><img src="<?= $f["image"] ?>"></td>
        <td>
            <button class="action-btn edit">Sửa</button>
            <button class="action-btn delete">Xóa</button>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<a href="index.php" style="
    display:inline-block;
    background:#2196F3; 
    color:white; 
    padding:8px 12px; 
    border-radius:4px; 
    text-decoration:none;
">
    ← Return to Index Page 
</a>

</body>
</html>
