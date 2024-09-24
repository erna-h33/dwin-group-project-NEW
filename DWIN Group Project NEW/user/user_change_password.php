<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

$owner_id = $_SESSION['user_id'];

// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch owner's current password from the database
    $stmt = $pdo->prepare("SELECT password FROM Users WHERE id = ?");
    $stmt->execute([$owner_id]);
    $owner = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($new_password !== $confirm_password) {
        $error = "New password and confirm password do not match.";
    } elseif ($current_password !== $owner['password']) {  // Note: Use hashing in production
        $error = "Current password is incorrect.";
    } else {
        // Update the owner's password
        $stmt = $pdo->prepare("UPDATE Users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $owner_id]);
        $success = "Password updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
</head>
<body>
    <h1>Change Password</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br>

        <button type="submit">Change Password</button>
    </form>

    <a href="user_home.php">Back to Dashboard</a>
</body>
</html>
