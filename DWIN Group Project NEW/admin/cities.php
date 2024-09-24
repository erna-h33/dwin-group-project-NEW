<?php
session_start();
require '../config.php';  

// Check if the user is logged in as admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch states for dropdown
$stmt_states = $pdo->query("SELECT s.*, c.name AS country_name FROM States s JOIN Countries c ON s.country_id = c.id");
$states = $stmt_states->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for adding or updating a city
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_id'])) {
        // Update existing city
        $update_id = $_POST['update_id'];
        $city_name = $_POST['city_name'];
        $state_id = $_POST['state_id'];

        $stmt = $pdo->prepare("UPDATE Cities SET name = ?, state_id = ? WHERE id = ?");
        $stmt->execute([$city_name, $state_id, $update_id]);
        $success = "City updated successfully!";
    } else {
        // Insert new city
        $city_name = $_POST['city_name'];
        $state_id = $_POST['state_id'];
        
        $stmt = $pdo->prepare("INSERT INTO Cities (name, state_id) VALUES (?, ?)");
        $stmt->execute([$city_name, $state_id]);
        $success = "City added successfully!";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM Cities WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "City deleted successfully!";
}

// Fetch all existing cities
$stmt = $pdo->query("SELECT ci.*, s.name AS state_name, c.name AS country_name 
                     FROM Cities ci 
                     JOIN States s ON ci.state_id = s.id 
                     JOIN Countries c ON s.country_id = c.id");
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cities</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="admin.css" />
</head>
<body>
    <h1>Manage Cities</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <h2>Add New City</h2>
    <form method="post">
        <label for="city_name">City Name:</label>
        <input type="text" name="city_name" required>
        <label for="state_id">State:</label>
        <select name="state_id" required>
            <?php foreach ($states as $state): ?>
                <option value="<?php echo $state['id']; ?>"><?php echo htmlspecialchars($state['name']) . ' (' . htmlspecialchars($state['country_name']) . ')'; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add City</button>
    </form>

    <h2>Existing Cities</h2>
    <table border="1" class="property-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>City Name</th>
                <th>State</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cities as $city): ?>
            <tr>
                <td><?php echo $city['id']; ?></td>
                <td><?php echo htmlspecialchars($city['name']); ?></td>
                <td><?php echo htmlspecialchars($city['state_name']); ?></td>
                <td><?php echo htmlspecialchars($city['country_name']); ?></td>
                <td>
                    <form style="display:inline;" method="post">
                        <input type="hidden" name="update_id" value="<?php echo $city['id']; ?>">
                        <input type="text" name="city_name" value="<?php echo htmlspecialchars($city['name']); ?>">
                        <select name="state_id">
                            <?php foreach ($states as $state): ?>
                                <option value="<?php echo $state['id']; ?>" <?php echo $city['state_id'] == $state['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($state['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                    <a href="?delete_id=<?php echo $city['id']; ?>" onclick="return confirm('Are you sure you want to delete this city?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
