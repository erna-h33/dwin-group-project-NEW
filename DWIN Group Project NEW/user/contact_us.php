<?php
require '../config.php';  

// Fetch the "Contact Us" content from the Pages table
$stmt = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'contact_us'");
$stmt->execute();
$contact_us_content = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>
    <p><?php echo nl2br(htmlspecialchars($contact_us_content)); ?></p>  
</body>
</html>
