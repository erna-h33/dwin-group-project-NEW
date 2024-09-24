<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

// Get owner's current profile information
$owner_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Update the owner's profile in the database
    $stmt = $pdo->prepare("UPDATE Users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$new_name, $new_email, $owner_id]);

    $success = "Profile updated successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($owner['name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($owner['email']); ?>" required><br>

        <button type="submit">Update Profile</button>
    </form>

    <a href="user_home.php">Back to Dashboard</a>
</body>
</html>
