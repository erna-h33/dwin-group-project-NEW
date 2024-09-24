<?php
session_start();
require '../config.php';  // Include the database connection

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

$customer_name = $_SESSION['user_name'];  // Get the customer name from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE COMMERCIAL Real Estate</title>
    <!-- Add Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&family=Lato:wght@300;400;700&display=swap"
      rel="stylesheet"
    />
    <!-- Add Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="customer.css" />
    <!-- <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <style>
        /* Simple CSS for the navigation bar */
        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .welcome-message {
            margin-top: 20px;
        }
    </style> -->
</head>
<body>

    <!-- Navigation Bar -->
    <header>
      <div class="logo">
        <a href="customer_home.php">Core Commercial</a>
      </div>
      <nav>
        <ul>
          <li><a href="customer_home.php">Home</a></li>
          <li><a href="customer_profile.php">View Profile</a></li>
          <li><a href="customer_view_properties.php">View Properties</a></li>
          <li><a href="contact_us.php">Contact Us</a></li>
        </ul>
      </nav>
    </header>
    <!-- <div class="navbar">
        <a href="customer_home.php">Home</a>
        <a href="customer_profile.php">Profile</a>
        <a href="customer_view_properties.php">View Properties</a>
    </div> -->

    <!-- Welcome message for the customer -->
    <div class="welcome-message container-extra-margin">
        <div class="welcome-wrapper">
            <h1>Welcome, <?php echo htmlspecialchars($customer_name); ?>!</h1>
            <p>Welcome to your dashboard! You can use the navigation bar to manage your profile or browse available properties.</p>
        </div>
        
        <div class="cust_dashboard_boxes">
        <div class="cust_dashboard_box">
            <a href="customer_home.php" class="cta-button">Go to Home</a>
        </div>
        <div class="cust_dashboard_box">
            <a href="customer_profile.php" class="cta-button">View Profile</a>
        </div>
        <div class="cust_dashboard_box">
            <a href="customer_view_properties.php" class="cta-button">View Property</a>
        </div>
        </div>
    </div>
    <footer>
      <p>
        &copy; <span id="year"></span> CORE COMMERCIAL Real Estate. All rights
        reserved.
      </p>
    </footer>

    <!-- JavaScript for dynamic year -->
    <script>
      // Set the current year in the footer
      document.getElementById("year").textContent = new Date().getFullYear();
    </script>

</body>
</html>
