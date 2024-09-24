<?php
session_start();
require '../config.php';  

// Check if the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch all users with the role 'owner'
$stmt = $pdo->query("SELECT * FROM Users WHERE role = 'owner'");
$owners = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Owners</title>
</head>
<body>
    <h1>Property Owners</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date Registered</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($owners as $owner): ?>
            <tr>
                <td><?php echo $owner['id']; ?></td>
                <td><?php echo htmlspecialchars($owner['name']); ?></td>
                <td><?php echo htmlspecialchars($owner['email']); ?></td>
                <td><?php echo $owner['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
