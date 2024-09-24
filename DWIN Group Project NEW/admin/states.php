<?php
session_start();
require '../config.php';  

// Check if the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch countries for dropdown
$stmt_countries = $pdo->query("SELECT * FROM Countries");
$countries = $stmt_countries->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for adding or updating a state
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_id'])) {
        // Update existing state
        $update_id = $_POST['update_id'];
        $state_name = $_POST['state_name'];
        $country_id = $_POST['country_id'];

        $stmt = $pdo->prepare("UPDATE States SET name = ?, country_id = ? WHERE id = ?");
        $stmt->execute([$state_name, $country_id, $update_id]);
        $success = "State updated successfully!";
    } else {
        // Insert new state
        $state_name = $_POST['state_name'];
        $country_id = $_POST['country_id'];
        
        $stmt = $pdo->prepare("INSERT INTO States (name, country_id) VALUES (?, ?)");
        $stmt->execute([$state_name, $country_id]);
        $success = "State added successfully!";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM States WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "State deleted successfully!";
}

// Fetch all existing states
$stmt = $pdo->query("SELECT s.*, c.name AS country_name FROM States s JOIN Countries c ON s.country_id = c.id");
$states = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage States</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="admin.css" />
</head>
<body>
    <h1>Manage States</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <h2>Add New State</h2>
    <form method="post">
        <label for="state_name">State Name:</label>
        <input type="text" name="state_name" required>
        <label for="country_id">Country:</label>
        <select name="country_id" required>
            <?php foreach ($countries as $country): ?>
                <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add State</button>
    </form>

    <h2>Existing States</h2>
    <table border="1" class="property-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>State Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($states as $state): ?>
            <tr>
                <td><?php echo $state['id']; ?></td>
                <td><?php echo htmlspecialchars($state['name']); ?></td>
                <td><?php echo htmlspecialchars($state['country_name']); ?></td>
                <td>
                    <form style="display:inline;" method="post">
                        <input type="hidden" name="update_id" value="<?php echo $state['id']; ?>">
                        <input type="text" name="state_name" value="<?php echo htmlspecialchars($state['name']); ?>">
                        <select name="country_id">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['id']; ?>" <?php echo $state['country_id'] == $country['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($country['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                    <a href="?delete_id=<?php echo $state['id']; ?>" onclick="return confirm('Are you sure you want to delete this state?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
