<?php
require '../config.php';  

// Get the user ID from the URL
$user_id = $_GET['id'];

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password and confirmation match
    if ($new_password === $confirm_password) {
        // Update the user's password in the database
        $stmt = $pdo->prepare("UPDATE Users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $user_id]);
        $success = "Password reset successfully!";
    } else {
        $error = "New password and confirm password do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br>

        <button type="submit">Reset Password</button>
    </form>

    <a href="login.php">Back to Login</a>
</body>
</html>
