<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

// Get customer's current profile information
$customer_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE Users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$new_name, $new_email, $customer_id]);

    $success = "Profile updated successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
                <li><a href="customer_dashboard.php" class="account-btn"><i class="fas fa-user"></i> My Account</a>
                </li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="margin-top-60 margin-bottom-40">
            <h1 class="heading-large">Edit Profile</h1>
        </div>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="margin-bottom-20">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required><br>
            </div>
           
            <div class="margin-bottom-20">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required><br>
            </div>
            <button type="submit" class="cta-button margin-bottom-20">Update Profile</button>
        </form>

        <div class="margin-top-40">
        <a href="customer_profile.php"  class="cta-button dark-button">Back to Profile</a>
        <a href="customer_dashboard.php" class="cta-button dark-button margin-left-10">Back to Dashboard</a>
        </div>
        
    </section>
    
    <footer>
        <p>&copy; <span id="year"></span> CORE COMMERCIAL Real Estate. All rights reserved.</p>
    </footer>
</body>
</html>
