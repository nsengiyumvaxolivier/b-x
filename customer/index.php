<?php
session_start();
$url = $_GET['url'] ?? "business";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Ordering Page</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>
<body>
    <?php
    $file = $url.".php";
    if (file_exists($file)) {
        include($file);
    }
    ?>
    
</body>
</html>