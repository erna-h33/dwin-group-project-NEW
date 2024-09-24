<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

// Fetch filter options for Property Types and Cities
$stmt_property_types = $pdo->query("SELECT id, name FROM PropertyTypes");
$property_types = $stmt_property_types->fetchAll(PDO::FETCH_ASSOC);

$stmt_cities = $pdo->query("SELECT id, name FROM Cities");
$cities = $stmt_cities->fetchAll(PDO::FETCH_ASSOC);

// Handle the filtering form submission
$property_type_id = isset($_GET['property_type']) ? $_GET['property_type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$city_id = isset($_GET['city']) ? $_GET['city'] : '';

// Build the query to fetch properties based on selected filters
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

$params = [];

// Apply property type filter if selected
if ($property_type_id != '') {
    $query .= " AND p.property_type_id = ?";
    $params[] = $property_type_id;
}

// Apply status filter if selected
if ($status != '') {
    $query .= " AND p.status = ?";
    $params[] = $status;
}

// Apply city filter if selected
if ($city_id != '') {
    $query .= " AND p.city_id = ?";
    $params[] = $city_id;
}

// Execute the query with filters
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Properties</title>
</head>
<body>
    <h1>View Properties</h1>

    <form method="get">
        <label for="property_type">Property Type:</label>
        <select name="property_type" id="property_type">
            <option value="">All</option>
            <?php foreach ($property_types as $type): ?>
                <option value="<?php echo $type['id']; ?>" <?php if ($property_type_id == $type['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($type['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="available" <?php if ($status == 'available') echo 'selected'; ?>>Available</option>
            <option value="sold" <?php if ($status == 'sold') echo 'selected'; ?>>Sold</option>
            <option value="rented" <?php if ($status == 'rented') echo 'selected'; ?>>Rented</option>
        </select>

        <label for="city">City:</label>
        <select name="city" id="city">
            <option value="">All</option>
            <?php foreach ($cities as $city): ?>
                <option value="<?php echo $city['id']; ?>" <?php if ($city_id == $city['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($city['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Price</th>
                <th>Status</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($properties as $property): ?>
            <tr>
                <td><?php echo $property['id']; ?></td>
                <td><?php echo htmlspecialchars($property['name']); ?></td>
                <td><?php echo htmlspecialchars($property['property_type']); ?></td>
                <td>
                    <?php echo htmlspecialchars($property['city_name'] . ', ' . $property['state_name'] . ', ' . $property['country_name']); ?>
                </td>
                <td><?php echo $property['price']; ?></td>
                <td><?php echo htmlspecialchars($property['status']); ?></td>
                <td><?php echo htmlspecialchars($property['owner_name']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="user_home.php">Back to Dashboard</a>
</body>
</html>
