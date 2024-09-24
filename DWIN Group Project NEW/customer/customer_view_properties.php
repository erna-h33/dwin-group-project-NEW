<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
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
    WHERE p.status = 'available'
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
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="customer.css" />
</head>


<body>
<header>
      <div class="logo">
        <a href="customer_home.php">Core Commercial</a>
      </div>
      <nav>
        <ul>
        <li><a href="customer_home.php">Home</a></li>
          <li><a href="about_us.php">About</a></li>
          <li><a href="customer_view_properties.php">Properties</a></li>
          <li><a href="contact_us.php">Contact Us</a></li>
          <li>
            <a href="customer_dashboard.php" class="account-btn"
              ><i class="fas fa-user"></i> My Account</a
            >
          </li>
        </ul>
      </nav>
    </header>
    <section class="light-bg">

    <div class="property-hero"></div>
    <h1 class="heading-large">Available Properties</h1>

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

        <button type="submit" class="cta-button margin-left-10">Filter</button>
    </form>

    <table border="1" class="property-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Price</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Actions</th>
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
                <td>
                    <a href="customer_send_enquiry.php?property_id=<?php echo $property['id']; ?>">Send Enquiry</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="customer_dashboard.php" class="cta-button">Back to Dashboard</a>
    </section>
    <footer>
      <p>
        &copy; <span id="year"></span> CORE COMMERCIAL Real Estate. All rights
        reserved.
      </p>
    </footer>

    <!-- JavaScript for dynamic year -->
    <script>
      // Set the current year in the footer
      document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>
