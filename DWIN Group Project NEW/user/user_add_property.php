<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

$owner_id = $_SESSION['user_id'];

// Fetch Property Types for dropdown
$stmt_property_types = $pdo->query("SELECT id, name FROM PropertyTypes");
$property_types = $stmt_property_types->fetchAll(PDO::FETCH_ASSOC);

// Fetch Countries for dropdown
$stmt_countries = $pdo->query("SELECT id, name FROM Countries");
$countries = $stmt_countries->fetchAll(PDO::FETCH_ASSOC);

// Fetch States based on the selected country (later will use JS for dynamic states selection)
$stmt_states = $pdo->query("SELECT id, name FROM States");
$states = $stmt_states->fetchAll(PDO::FETCH_ASSOC);

// Fetch Cities based on the selected state (later will use JS for dynamic cities selection)
$stmt_cities = $pdo->query("SELECT id, name FROM Cities");
$cities = $stmt_cities->fetchAll(PDO::FETCH_ASSOC);

// Handle add property form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property_name = $_POST['name'];
    $property_description = $_POST['description'];
    $property_price = $_POST['price'];
    $property_type_id = $_POST['property_type'];
    $country_id = $_POST['country'];
    $state_id = $_POST['state'];
    $city_id = $_POST['city'];

    // Insert new property into the database
    $stmt = $pdo->prepare("INSERT INTO Properties (name, description, price, property_type_id, country_id, state_id, city_id, owner_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$property_name, $property_description, $property_price, $property_type_id, $country_id, $state_id, $city_id, $owner_id]);

    $success = "Property added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Property</title>
</head>
<body>
    <h1>Add Property</h1>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="name">Property Name:</label>
        <input type="text" name="name" required><br>

        <label for="description">Property Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <label for="property_type">Property Type:</label>
        <select name="property_type" required>
            <?php foreach ($property_types as $type): ?>
                <option value="<?php echo $type['id']; ?>"><?php echo htmlspecialchars($type['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="country">Country:</label>
        <select name="country" required>
            <?php foreach ($countries as $country): ?>
                <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="state">State:</label>
        <select name="state" required>
            <?php foreach ($states as $state): ?>
                <option value="<?php echo $state['id']; ?>"><?php echo htmlspecialchars($state['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="city">City:</label>
        <select name="city" required>
            <?php foreach ($cities as $city): ?>
                <option value="<?php echo $city['id']; ?>"><?php echo htmlspecialchars($city['name']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Add Property</button>
    </form>

    <a href="user_home.php">Back to Dashboard</a>
</body>
</html>
