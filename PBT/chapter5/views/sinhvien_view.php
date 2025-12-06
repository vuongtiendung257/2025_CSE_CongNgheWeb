
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 5 - Kiến trúc MVC</title>
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
        .form-container-submit 
        {
            display: block;
            margin: 0 auto;
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
    <h2 >Thêm Sinh Viên Mới (MVC)</h2>
    <form action="index.php" method="POST">
        <label for="ten_sinh_vien"> Tên sinh viên: </label>
        <input type="text" name="ten_sinh_vien" placeholder="Nhập tên sinh viên" required>
        <label for="email"> Email: </label>
        <input type="email" name="email" placeholder="Nhập email" required>
        <button type="submit" class = "form-container-submit">Thêm Sinh Viên</button>
    </form>
</div>


<h2>Danh Sách Sinh Viên (MVC)</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tên Sinh Viên</th>
        <th>Email</th>
        <th>Ngày Tạo</th>
    </tr>

 <?php if (!empty($list_sv)) : ?>
    <?php foreach ($list_sv as $sv) : ?>
        <tr>
            <td><?= htmlspecialchars($sv['id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['ten_sinh_vien'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($sv['ngay_tao'], ENT_QUOTES) ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="empty">Không có sinh viên nào.</td>
    </tr>
<?php endif; ?>
 
</table>

</body>
</html>