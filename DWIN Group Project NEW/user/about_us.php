<?php
require '../config.php';  

// Fetch the "About Us" content from the Pages table
$stmt = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'about_us'");
$stmt->execute();
$about_us_content = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us</title>
</head>
<body>
    <h1>About Us</h1>
    <p><?php echo nl2br(htmlspecialchars($about_us_content)); ?></p>  
</body>
</html>
