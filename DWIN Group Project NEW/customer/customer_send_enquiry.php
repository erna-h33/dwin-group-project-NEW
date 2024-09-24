<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];  // Get the customer ID from the session
$property_id = $_GET['property_id'];

// Fetch property details
$stmt = $pdo->prepare("
    SELECT p.name AS property_name, pt.name AS property_type, u.name AS owner_name 
    FROM Properties p
    JOIN PropertyTypes pt ON p.property_type_id = pt.id
    JOIN Users u ON p.owner_id = u.id
    WHERE p.id = ?
");
$stmt->execute([$property_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle enquiry form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    // Insert the enquiry into the Enquiries table
    $stmt = $pdo->prepare("INSERT INTO Enquiries (property_id, user_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$property_id, $customer_id, $message]);

    $success = "Enquiry sent successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Enquiry</title>
</head>
<body>
    <h1>Send Enquiry for <?php echo htmlspecialchars($property['property_name']); ?></h1>

    <p><strong>Property Type:</strong> <?php echo htmlspecialchars($property['property_type']); ?></p>
    <p><strong>Owner:</strong> <?php echo htmlspecialchars($property['owner_name']); ?></p>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="message">Your Enquiry Message:</label><br>
        <textarea name="message" rows="5" cols="50" required></textarea><br>

        <button type="submit">Send Enquiry</button>
    </form>

    <a href="customer_view_properties.php">Back to Properties</a>
</body>
</html>
