<?php
session_start();
require '../config.php';  

// Check if the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle form submission for adding or updating a country
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_id'])) {
        // Update existing country
        $update_id = $_POST['update_id'];
        $country_name = $_POST['country_name'];

        $stmt = $pdo->prepare("UPDATE Countries SET name = ? WHERE id = ?");
        $stmt->execute([$country_name, $update_id]);
        $success = "Country updated successfully!";
    } else {
        // Insert new country
        $country_name = $_POST['country_name'];
        
        $stmt = $pdo->prepare("INSERT INTO Countries (name) VALUES (?)");
        $stmt->execute([$country_name]);
        $success = "Country added successfully!";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM Countries WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "Country deleted successfully!";
}

// Fetch all existing countries
$stmt = $pdo->query("SELECT * FROM Countries");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Countries</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="admin.css" />
</head>
<body>
    <h1>Manage Countries</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <h2>Add New Country</h2>
    <form method="post">
        <label for="country_name">Country Name:</label>
        <input type="text" name="country_name" required>
        <button type="submit">Add Country</button>
    </form>

    <h2>Existing Countries</h2>
    <table border="1" class="property-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Country Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($countries as $country): ?>
            <tr>
                <td><?php echo $country['id']; ?></td>
                <td><?php echo htmlspecialchars($country['name']); ?></td>
                <td>
                    <form style="display:inline;" method="post">
                        <input type="hidden" name="update_id" value="<?php echo $country['id']; ?>">
                        <input type="text" name="country_name" value="<?php echo htmlspecialchars($country['name']); ?>">
                        <button type="submit">Update</button>
                    </form>
                    <a href="?delete_id=<?php echo $country['id']; ?>" onclick="return confirm('Are you sure you want to delete this country?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
