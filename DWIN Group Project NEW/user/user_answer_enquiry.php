<?php
session_start();
require '../config.php';  

// Ensure the user is logged in as an owner
if ($_SESSION['user_role'] != 'owner') {
    header('Location: ../login.php');
    exit();
}

$enquiry_id = $_GET['enquiry_id'];

// Fetch the enquiry details and the associated property details
$stmt_enquiry = $pdo->prepare("
    SELECT e.*, p.name AS property_name, p.description AS property_description, p.price, 
           pt.name AS property_type, c.name AS country_name, s.name AS state_name, ci.name AS city_name
    FROM Enquiries e
    JOIN Properties p ON e.property_id = p.id
    JOIN PropertyTypes pt ON p.property_type_id = pt.id
    JOIN Countries c ON p.country_id = c.id
    JOIN States s ON p.state_id = s.id
    JOIN Cities ci ON p.city_id = ci.id
    WHERE e.id = ?
");
$stmt_enquiry->execute([$enquiry_id]);
$enquiry = $stmt_enquiry->fetch(PDO::FETCH_ASSOC);

// Handle form submission for answering the enquiry
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = $_POST['response'];

    // Update the enquiry with the owner's response
    $stmt = $pdo->prepare("UPDATE Enquiries SET response = ? WHERE id = ?");
    $stmt->execute([$response, $enquiry_id]);

    $success = "Response sent successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Answer Enquiry</title>
</head>
<body>
    <h1>Answer Enquiry for Property: <?php echo htmlspecialchars($enquiry['property_name']); ?></h1>

    <p><strong>Type:</strong> <?php echo htmlspecialchars($enquiry['property_type']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($enquiry['city_name'] . ', ' . $enquiry['state_name'] . ', ' . $enquiry['country_name']); ?></p>
    <p><strong>Price:</strong> <?php echo $enquiry['price']; ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($enquiry['property_description']); ?></p>

    <h3>Customer Enquiry</h3>
    <p><?php echo htmlspecialchars($enquiry['message']); ?></p>

    <h3>Your Response</h3>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="response">Your Response:</label>
        <textarea name="response" required><?php echo htmlspecialchars($enquiry['response']); ?></textarea><br>

        <button type="submit">Send Response</button>
    </form>

    <a href="user_view_enquiries.php?property_id=<?php echo $enquiry['property_id']; ?>">Back to Enquiries</a>
</body>
</html>
