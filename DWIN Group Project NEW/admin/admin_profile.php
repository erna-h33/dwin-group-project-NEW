<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch the admin's profile information
$admin_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
</head>
<body>
    <h1>Admin Profile</h1>

    <h2>Profile Information</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($admin['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>

    <h3>Manage Your Account</h3>
    <ul>
        <li><a href="update_profile.php">Update Profile</a></li>
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="recover_password.php">Recover Password</a></li>
    </ul>

    <h3><a href="logout.php">Logout</a></h3>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
