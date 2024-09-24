<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch customer's current password from the database
    $stmt = $pdo->prepare("SELECT password FROM Users WHERE id = ?");
    $stmt->execute([$customer_id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($new_password !== $confirm_password) {
        $error = "New password and confirm password do not match.";
    } elseif ($current_password !== $customer['password']) {  
        $error = "Current password is incorrect.";
    } else {
        $stmt = $pdo->prepare("UPDATE Users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $customer_id]);
        $success = "Password updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="customer.css" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="customer_home.php">Core Commercial</a>
        </div>
        <nav>
            <ul>
                <li><a href="customer_home.php">Home</a></li>
                <li><a href="about_us.php">About</a></li>
                <li><a href="customer_view_properties.php">Properties</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="customer_dashboard.php" class="account-btn"><i class="fas fa-user"></i> My Account</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="margin-top-60 margin-bottom-40">
            <h1 class="heading-large">Change Password</h1>
        </div>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="margin-bottom-20">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" required><br>
            </div>

            <div class="margin-bottom-20">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required><br>
            </div>

            <div class="margin-bottom-20">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" required><br>
            </div>
    
            <button type="submit" class="cta-button margin-bottom-20">Change Password</button>
        </form>

        <div class="margin-top-40">
            <a href="customer_profile.php"  class="cta-button dark-button">Back to Profile</a>
            <a href="customer_dashboard.php"  class="cta-button dark-button margin-left-10">Back to Dashboard</a>
        </div>
    </section>

    <footer>
        <p>&copy; <span id="year"></span> CORE COMMERCIAL Real Estate. All rights reserved.</p>
    </footer>
</body>
</html>
