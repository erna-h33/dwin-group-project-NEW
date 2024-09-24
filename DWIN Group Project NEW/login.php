<?php
session_start();
require 'config.php';  // Include the database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];  

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header('Location: admin/admin_dashboard.php');
        } elseif ($user['role'] == 'owner') {
            header('Location: user/user_home.php');
        } else {
            header('Location: customer/customer_dashboard.php');
        }
        exit(); 
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Add Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&family=Lato:wght@300;400;700&display=swap"
      rel="stylesheet"
    />
    <!-- Add Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="global.css" />
    <link rel="stylesheet" href="styles/login.css" />
</head>
<body>
    <section>
        <div class="login-form-container dark-bg">
            <h1>Login</h1>
                <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
    
            <form method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <button type="submit" class="button-outline">Login</button>
            </form>
        </div>
    </section>
    
</body>
</html>
