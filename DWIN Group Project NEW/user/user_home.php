<?php
session_start();
require '../config.php';  

// Ensure the user is logged in
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

$user_name = $_SESSION['user_name'];  // Get the user's name from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Home</title>
    <style>
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
    </style>
</head>
<body>

    <div class="navbar">
        <a href="user_home.php">Home</a>
        <a href="about_us.php">About Us</a>
        <a href="user_view_properties.php">Properties</a>
        <a href="contact_us.php">Contact Us</a>
        <a href="user_profile.php">Profile</a>
        <a href="user_add_property.php">Add Property</a>
        <a href="user_my_properties.php">My Property</a>
        <a href="user_logout.php">Logout</a>
    </div>

    <div class="welcome-message">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p>Welcome to your home page! You can use the navigation bar to manage your profile, properties, and view enquiries.</p>
    </div>

</body>
</html>
