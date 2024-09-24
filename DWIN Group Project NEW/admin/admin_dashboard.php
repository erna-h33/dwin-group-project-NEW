<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Total property types
$stmt = $pdo->query("SELECT COUNT(*) AS total_property_types FROM PropertyTypes");
$total_property_types = $stmt->fetchColumn();

// Total countries
$stmt = $pdo->query("SELECT COUNT(*) AS total_countries FROM Countries");
$total_countries = $stmt->fetchColumn();

// Total states
$stmt = $pdo->query("SELECT COUNT(*) AS total_states FROM States");
$total_states = $stmt->fetchColumn();

// Total cities
$stmt = $pdo->query("SELECT COUNT(*) AS total_cities FROM Cities");
$total_cities = $stmt->fetchColumn();

// Total agents 
$stmt = $pdo->query("SELECT COUNT(*) AS total_agents FROM Users WHERE role = 'agent'");
$total_agents = $stmt->fetchColumn();

// Total owners 
$stmt = $pdo->query("SELECT COUNT(*) AS total_owners FROM Users WHERE role = 'owner'");
$total_owners = $stmt->fetchColumn();

// Total customers 
$stmt = $pdo->query("SELECT COUNT(*) AS total_customers FROM Users WHERE role = 'customer'");
$total_customers = $stmt->fetchColumn();

// Total properties listed
$stmt = $pdo->query("SELECT COUNT(*) AS total_properties FROM Properties");
$total_properties = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="admin.css" />
</head>
<body>

    <main class="dark-bg">
    <section>
        <div class="dashboard-header">
            <h1 class="margin-bottom-40 heading-large light-gold-text">Core Commercial</h1>
        </div>
        <div class="dashboard-buttons">
        <a href="admin_dashboard.php" class="button-outline">Dashboard</a>
        <a href="admin_profile.php" class="button-outline">Profile</a>
        <a href="manage_pages.php" class="button-outline">Manage Pages</a> 
        <a href="logout.php" class="button-outline">Logout</a>
    </div>
    </section>

    <section class="admin-properties-list">
        <h1 class="heading-large margin-bottom-40">Admin Dashboard</h1>
        <ul>
            <li><a href="property_type.php">Total Property Types: <?php echo $total_property_types; ?></a></li>
            <li><a href="countries.php">Total Countries: <?php echo $total_countries; ?></a></li>
            <li><a href="states.php">Total States: <?php echo $total_states; ?></a></li>
            <li><a href="cities.php">Total Cities: <?php echo $total_cities; ?></a></li>
            <li><a href="view_agents.php">Total Agents: <?php echo $total_agents; ?></a></li>
            <li><a href="view_owners.php">Total Owners: <?php echo $total_owners; ?></a></li>
            <li><a href="view_customers.php">Total Customers (Buyers): <?php echo $total_customers; ?></a></li>
            <li><a href="view_properties.php">Total Properties Listed: <?php echo $total_properties; ?></a></li>
        </ul>
    </section>

    
</main>
    
</body>
</html>
