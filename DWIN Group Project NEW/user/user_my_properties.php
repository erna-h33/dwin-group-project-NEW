<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

$owner_id = $_SESSION['user_id'];

// Fetch all properties added by the owner along with the related property type, country, state, and city
$stmt = $pdo->prepare("
    SELECT p.*, pt.name AS property_type, c.name AS country_name, s.name AS state_name, ci.name AS city_name 
    FROM Properties p
    JOIN PropertyTypes pt ON p.property_type_id = pt.id
    JOIN Countries c ON p.country_id = c.id
    JOIN States s ON p.state_id = s.id
    JOIN Cities ci ON p.city_id = ci.id
    WHERE p.owner_id = ?
");
$stmt->execute([$owner_id]);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Properties</title>
</head>
<body>
    <h1>My Listed Properties</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Type</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($properties as $property): ?>
            <tr>
                <td><?php echo $property['id']; ?></td>
                <td><?php echo htmlspecialchars($property['name']); ?></td>
                <td><?php echo htmlspecialchars($property['description']); ?></td>
                <td><?php echo $property['price']; ?></td>
                <td><?php echo htmlspecialchars($property['property_type']); ?></td>
                <td>
                    <?php echo htmlspecialchars($property['city_name'] . ', ' . $property['state_name'] . ', ' . $property['country_name']); ?>
                </td>
                <td><?php echo $property['status']; ?></td>
                <td><a href="user_view_enquiries.php?property_id=<?php echo $property['id']; ?>">View Enquiries</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="user_home.php">Back to Dashboard</a>
</body>
</html>
