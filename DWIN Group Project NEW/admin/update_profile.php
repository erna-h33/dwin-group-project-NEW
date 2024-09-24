<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Get admin's current profile information
$admin_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Update the admin's name and email in the database
    $stmt = $pdo->prepare("UPDATE Users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$new_name, $new_email, $admin_id]);

    $success = "Profile updated successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
</head>
<body>
    <h1>Update Profile</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required><br>

        <button type="submit">Update Profile</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
