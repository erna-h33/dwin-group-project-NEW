<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

// Fetch the customer's profile details
$customer_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Profile</title>
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
          <li>
            <a href="customer_dashboard.php" class="account-btn"
              ><i class="fas fa-user"></i> My Account</a
            >
          </li>
        </ul>
      </nav>
    </header>
    <section>
        <div class="margin-top-60 margin-bottom-40">
            <h2>Customer Profile Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
        </div>
    

        <h2>Manage Your Account</h2>
          <ul>
            <li><a href="customer_edit_profile.php" class="cta-button margin-bottom-20">Edit Profile</a></li>
            <li><a href="customer_change_password.php" class="cta-button margin-bottom-20">Change Password</a></li>
            <li><a href="customer_logout.php" class="cta-button margin-bottom-20">Logout</a></li>
          </ul>
        

        <a href="customer_dashboard.php" class="cta-button dark-button">Back to Dashboard</a>
    </section>
    
    <footer>
      <p>
        &copy; <span id="year"></span> CORE COMMERCIAL Real Estate. All rights
        reserved.
      </p>
    </footer>
</body>
</html>
