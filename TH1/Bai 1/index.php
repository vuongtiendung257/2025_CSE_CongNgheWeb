<?php
require 'data_flower.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách loài hoa</title>
    <link rel="icon" type="image/png" href="images/fav.png">

    <style>
        body 
        { 
            font-family: Arial; 
            max-width: 1000px; 
            margin: auto; 
            text-align: justify 
        }
        .flower {
            padding: 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid #ddd;
        }
        .flower img {
            width: 300px;
            border-radius: 8px;
        }
        h2 { color: #e91e63; }
    </style>
</head>

<body>
    <h1>🌸 Những loài hoa tuyệt đẹp</h1>

    <?php foreach ($flowers as $hoa): ?>
        <h2><?php echo htmlspecialchars($hoa['name'], ENT_QUOTES); ?></h2>
        <img src="<?php echo htmlspecialchars($hoa['image'], ENT_QUOTES); ?>" width="300">
        <p><?php echo nl2br(htmlspecialchars($hoa['description'], ENT_QUOTES)); ?></p>
    <?php endforeach; ?>

<a href="admin.php" style="
    display:inline-block;
    background:#2196F3; 
    color:white; 
    padding:8px 12px; 
    border-radius:4px; 
    text-decoration:none;
">
    Foward to Admin Panel -> 
</a>


</body>
</html>
