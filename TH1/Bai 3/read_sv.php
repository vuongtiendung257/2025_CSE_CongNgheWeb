<?php

$file_name = '65HTTT_Danh_sach_diem_danh.csv';

if (!is_file($file_name)) 
{
    exit('<h3 style="color:red;text-align:center;">Lỗi: Không thấy file ' . $file_name . ' trong thư mục!</h3>');
}

// Đọc hết file vào bộ nhớ và loại bỏ BOM (dấu lạ đầu file Excel)
$content = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($content === false) 
{
    exit('Không đọc được file!');
}

// Xóa BOM ở dòng đầu tiên nếu có
if (strpos($content[0], "\xEF\xBB\xBF") === 0) 
{
    $content[0] = substr($content[0], 3);
}

$header = str_getcsv($content[0]);        // lấy dòng đầu làm tiêu đề
$list_sv = [];

for ($i = 1; $i < count($content); $i++) 
{
    $row = str_getcsv($content[$i]);
    if (count($row) < 2) continue;         // bỏ dòng trống

    // Ghép tiêu đề với dữ liệu từng dòng
    $sv = [];
    foreach ($header as $k => $row_name) {
        $sv[$row_name] = $row[$k] ?? '';
    }
    $list_sv[] = $sv;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>65HTTT - Danh sách điểm danh</title>
    <style>
        body 
        {
            font-family: Tahoma; 
            margin: 30px; 
            background: #f9f9f9;
        }
        h2 
        {
            color: #0066cc; 
            text-align: center;
        }
        .tong 
        {
            text-align: center; 
            font-size: 18px; 
            color: green; 
            margin: 15px;
        }
        table 
        {
            width: 90%; 
            margin: auto; 
            border-collapse: collapse; 
            background: white;
        }
        th 
        {
            background: #0066cc; 
            color: white; 
            padding: 10px;
        }
        td 
        {
            padding: 8px; 
            border: 1px solid #ddd;
        }
        tr:nth-child(even) 
        {
            background: #f2f2f2;
        }
        .mssv 
        {
            font-weight: bold; 
            color: #d35400;
        }
    </style>
</head>
<body>

<h2>THÔNG TIN LỚP 65HTTT - MÔN CSE485</h2>
<p class="tong">Tổng số sinh viên: <b><?php echo count($list_sv); ?></b></p>

<table>
    <thead>
        <tr>
            <?php 
            foreach ($header as $column_name)
            {
                echo "<th>" . htmlspecialchars($column_name) . "</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        $stt = 1;
        foreach ($list_sv as $one_sv) 
        { 
        ?>
            <tr>
                <td class="mssv"><?php echo htmlspecialchars($one_sv['username']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['password']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['lastname']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['firstname']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['city']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['email']); ?></td>
                <td><?php echo htmlspecialchars($one_sv['course1']); ?></td>
            </tr>
        <?php 
            $stt++;
        } 
        ?>
    </tbody>
</table>

<!-- Hoạt động lưu vào cơ sở dữ liệu -->
<?php
/*
try {
    $connection = new PDO("mysql:host=localhost;dbname=cse485;charset=utf8", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT IGNORE INTO sinh_vien 
            (mssv, mat_khau, ho, ten, lop, email, ma_mon) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $commant = $connection->prepare($sql);

    foreach ($list_sv as $sv) {
        $commant->execute([
            $sv['username'],
            password_hash($sv['password'], PASSWORD_DEFAULT),
            $sv['lastname'],
            $sv['firstname'],
            $sv['city'],
            $sv['email'],
            $sv['course1']
        ]);
    }
    echo "<p style='text-align:center;color:green;font-size:20px;'>Đã import thành công tất cả sinh viên vào CSDL!</p>";
} catch (Exception $e) {
    echo "Lỗi CSDL: " . $e->getMessage();
}
*/
?>

</body>
</html>