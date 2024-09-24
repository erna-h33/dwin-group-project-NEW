<?php
session_start();
require '../config.php'; 

// Ensure the user is logged in
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

// Check if 'property_id' exists in the URL
if (!isset($_GET['property_id'])) {
    echo "Error: Property ID not provided.";
    exit();
}

$property_id = $_GET['property_id'];
$user_id = $_SESSION['user_id'];

// Fetch the property details based on the 'id' column in the 'Properties' table
$stmt = $pdo->prepare("
    SELECT p.id, p.name AS property_name, pt.name AS property_type, c.name AS country_name, s.name AS state_name, ci.name AS city_name, p.price, p.description 
    FROM Properties p
    JOIN PropertyTypes pt ON p.property_type_id = pt.id
    JOIN Countries c ON p.country_id = c.id
    JOIN States s ON p.state_id = s.id
    JOIN Cities ci ON p.city_id = ci.id
    WHERE p.id = ? AND p.owner_id = ?
");
$stmt->execute([$property_id, $user_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the property was found
if (!$property) {
    echo "Error: Property not found or you do not have permission to view this property.";
    exit();
}

// Fetch the enquiries for the property
$stmt_enquiries = $pdo->prepare("SELECT * FROM Enquiries WHERE property_id = ?");
$stmt_enquiries->execute([$property_id]);
$enquiries = $stmt_enquiries->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiries for Property</title>
</head>
<body>
    <h1>Enquiries for Property: <?php echo htmlspecialchars($property['property_name']); ?></h1>

    <p><strong>Type:</strong> <?php echo htmlspecialchars($property['property_type']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($property['city_name'] . ', ' . $property['state_name'] . ', ' . $property['country_name']); ?></p>
    <p><strong>Price:</strong> <?php echo htmlspecialchars($property['price']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($property['description']); ?></p>

    <h2>Enquiries</h2>
    <?php if (count($enquiries) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Message</th>
                    <th>Response</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enquiries as $enquiry): ?>
                <tr>
                    <td><?php echo $enquiry['id']; ?></td>
                    <td><?php echo htmlspecialchars($enquiry['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['message']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['response']); ?></td>
                    <td>
                        <a href="user_answer_enquiry.php?enquiry_id=<?php echo $enquiry['id']; ?>">Answer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No enquiries found for this property.</p>
    <?php endif; ?>

    <a href="user_my_properties.php">Back to My Properties</a>
</body>
</html>
