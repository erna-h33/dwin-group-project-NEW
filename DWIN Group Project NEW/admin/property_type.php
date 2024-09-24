<?php
session_start();
require '../config.php';  

// Check if the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle form submission for adding or updating property type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_id'])) {
        // Update existing property type
        $update_id = $_POST['update_id'];
        $property_type_name = $_POST['property_type'];

        $stmt = $pdo->prepare("UPDATE PropertyTypes SET name = ? WHERE id = ?");
        $stmt->execute([$property_type_name, $update_id]);
        $success = "Property Type updated successfully!";
    } else {
        // Insert new property type
        $property_type_name = $_POST['property_type'];
        
        $stmt = $pdo->prepare("INSERT INTO PropertyTypes (name) VALUES (?)");
        $stmt->execute([$property_type_name]);
        $success = "Property Type added successfully!";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM PropertyTypes WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "Property Type deleted successfully!";
}

// Fetch all existing property types
$stmt = $pdo->query("SELECT * FROM PropertyTypes");
$property_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Property Types</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="admin.css" />
</head>
<body>
    <section>
    <h1>Manage Property Types</h1>

<?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<h2>Add New Property Type</h2>
<form method="post">
    <label for="property_type">Property Type:</label>
    <input type="text" name="property_type" required>
    <button type="submit">Add Property Type</button>
</form>

<h2>Existing Property Types</h2>
<table border="1" class="property-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Property Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($property_types as $type): ?>
        <tr>
            <td><?php echo $type['id']; ?></td>
            <td><?php echo htmlspecialchars($type['name']); ?></td>
            <td>
                <form style="display:inline;" method="post">
                    <input type="hidden" name="update_id" value="<?php echo $type['id']; ?>">
                    <input type="text" name="property_type" value="<?php echo htmlspecialchars($type['name']); ?>">
                    <button type="submit">Update</button>
                </form>
                <a href="?delete_id=<?php echo $type['id']; ?>" onclick="return confirm('Are you sure you want to delete this property type?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="admin_dashboard.php">Back to Dashboard</a>
    </section>
    
</body>
</html>
