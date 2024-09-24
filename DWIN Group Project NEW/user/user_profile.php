<?php
session_start();
require '../config.php';  

// Ensure the user is logged in
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

// Fetch the user's profile details
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email FROM Users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
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
    </style>
</head>
<body>

    <div class="navbar">
        <a href="user_home.php">Home</a>
        <a href="about_us.php">About Us</a>
        <a href="user_view_properties.php">Properties</a>
        <a href="contact_us.php">Contact Us</a>
        <a href="user_add_property.php">Add Property</a>
        <a href="user_my_properties.php">My Property</a>
        <a href="user_view_enquiries.php">Enquiries</a>
    </div>

    <h1>User Profile</h1>

    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <h3>Manage Your Profile</h3>
    <ul>
        <li><a href="user_edit_profile.php">Edit Profile</a></li>
        <li><a href="user_change_password.php">Change Password</a></li>
        <li><a href="user_logout.php">Logout</a></li>
    </ul>

</body>
</html>
