<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Initialize variables for search criteria
$search_id = isset($_GET['property_id']) ? $_GET['property_id'] : '';
$search_name = isset($_GET['property_name']) ? $_GET['property_name'] : '';

$query = "
    SELECT p.*, pt.name AS property_type, c.name AS country_name, s.name AS state_name, ci.name AS city_name, u.name AS owner_name
    FROM Properties p
    JOIN PropertyTypes pt ON p.property_type_id = pt.id
    JOIN Countries c ON p.country_id = c.id
    JOIN States s ON p.state_id = s.id
    JOIN Cities ci ON p.city_id = ci.id
    JOIN Users u ON p.owner_id = u.id
    WHERE 1=1
";

// Prepare the conditions based on search inputs
$params = [];
if ($search_id != '') {
    $query .= " AND p.id = ?";
    $params[] = $search_id;
}
if ($search_name != '') {
    $query .= " AND p.name LIKE ?";
    $params[] = '%' . $search_name . '%';
}

// Execute the query with search parameters
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Listed Properties</title>
</head>
<body>
    <h1>Listed Properties</h1>

    <form method="get">
        <label for="property_id">Property ID:</label>
        <input type="text" name="property_id" id="property_id" value="<?php echo htmlspecialchars($search_id); ?>">

        <label for="property_name">Property Name:</label>
        <input type="text" name="property_name" id="property_name" value="<?php echo htmlspecialchars($search_name); ?>">

        <button type="submit">Search</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Price</th>
                <th>Owner</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($properties) > 0): ?>
                <?php foreach ($properties as $property): ?>
                <tr>
                    <td><?php echo $property['id']; ?></td>
                    <td><?php echo htmlspecialchars($property['name']); ?></td>
                    <td><?php echo htmlspecialchars($property['property_type']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($property['city_name'] . ', ' . $property['state_name'] . ', ' . $property['country_name']); ?>
                    </td>
                    <td><?php echo $property['price']; ?></td>
                    <td><?php echo htmlspecialchars($property['owner_name']); ?></td>
                    <td><?php echo htmlspecialchars($property['status']); ?></td>
                    <td><?php echo $property['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No properties found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
