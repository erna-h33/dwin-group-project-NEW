<?php
session_start();
require '../config.php';  

// Check if the user is an admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle form submission for updating the pages
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $about_us_content = $_POST['about_us_content'];
    $contact_us_content = $_POST['contact_us_content'];

    // Update "About Us" content
    $stmt = $pdo->prepare("UPDATE Pages SET content = ? WHERE page_name = 'about_us'");
    $stmt->execute([$about_us_content]);

    // Update "Contact Us" content
    $stmt = $pdo->prepare("UPDATE Pages SET content = ? WHERE page_name = 'contact_us'");
    $stmt->execute([$contact_us_content]);

    $success = "Pages updated successfully!";
}

// Fetch the current content of both pages
$stmt_about = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'about_us'");
$stmt_about->execute();
$about_us_content = $stmt_about->fetchColumn();

$stmt_contact = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'contact_us'");
$stmt_contact->execute();
$contact_us_content = $stmt_contact->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pages</title>
</head>
<body>
    <h1>Manage Pages</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <h2>About Us Page</h2>
        <textarea name="about_us_content" rows="10" cols="50"><?php echo htmlspecialchars($about_us_content); ?></textarea><br>

        <h2>Contact Us Page</h2>
        <textarea name="contact_us_content" rows="10" cols="50"><?php echo htmlspecialchars($contact_us_content); ?></textarea><br>

        <button type="submit">Update Pages</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
