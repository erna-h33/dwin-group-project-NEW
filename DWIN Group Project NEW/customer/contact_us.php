<?php
require '../config.php';  

// Fetch the "Contact Us" content from the Pages table
$stmt = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'contact_us'");
$stmt->execute();
$contact_us_content = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
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
<section class="contact-us">
    <div class="contact-container">
        <div class="contact-hero"></div>
    <div class="contact-content">
    <h2>Contact Us</h2>
        <form action="#" method="post" class="contact-form">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />
          </div>
          <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>
          <button type="submit" class="cta-button">Send Message</button>
        </form>
    </div>
    
    </div>
        
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

    <p><?php echo nl2br(htmlspecialchars($contact_us_content)); ?></p>  
</body>
</html>
