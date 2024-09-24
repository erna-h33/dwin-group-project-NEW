<?php
require '../config.php';  

// Handle password recovery form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT id FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // For simplicity, directly allow resetting the password
        header("Location: reset_password.php?id=" . $user['id']);  // Redirect to reset password page
        exit();
    } else {
        $error = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recover Password</title>
</head>
<body>
    <h1>Recover Password</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Recover Password</button>
    </form>

    <a href="/groupproject/login.php">Back to Login</a>
</body>
</html>
