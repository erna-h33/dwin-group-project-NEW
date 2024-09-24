<?php
require '../config.php';  

// Fetch the "About Us" content from the Pages table
$stmt = $pdo->prepare("SELECT content FROM Pages WHERE page_name = 'about_us'");
$stmt->execute();
$about_us_content = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us</title>
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="customer.css" />
</head>
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
<body>
    <!-- About Us Section -->
    <section class="about-us light-bg padding-top-100">
        <div class="about-content">
          <div class="about-text-container">
            <h2 class="dark-blue-text">About Us</h2>
            <p class="dark-blue-text">
              CORE COMMERCIAL Real Estate has been a leader in the Northern and
              Western Suburbs, offering unparalleled services for buying,
              selling, renting, and leasing properties. Our team of experts is
              dedicated to delivering a personalized experience, ensuring that
              each client receives the utmost care and attention in their real
              estate journey.<br /><br />
            </p>
            <p class="dark-blue-text">
              With a commitment to integrity, professionalism, and continuous
              learning, we stay ahead in the dynamic market landscape. Our
              collaborative approach allows us to cater to diverse needs, be it
              commercial or residential properties. At CORE COMMERCIAL, we are
              not just about transactions; we build relationships that last.
            </p>
          </div>
          <div class="about-image">
            <img
              src="../images/about-us.jpg"
              alt="About CORE COMMERCIAL Real Estate"
            />
          </div>
        </div>
      </section>

      <section class="team-section light-bg padding-top-100">
  <h2 class="dark-blue-text text-center">Meet Our Team</h2>
  <div class="team-container">
    <div class="team-member">
      <img src="../images/samia-avatar.webp" alt="Samia Sultana">
      <h3>Samia Sultana</h3>
      <p>CEO</p>
    </div>
    <div class="team-member">
      <img src="../images/team2.jpg" alt="Hendra Lim">
      <h3>Hendra Lim</h3>
      <p>COO</p>
    </div>
    <div class="team-member">
      <img src="../images/team3.jpg" alt="Erna Halim">
      <h3>Erna Halim</h3>
      <p>CFO</p>
    </div>
    <div class="team-member">
      <img src="../images/team4.jpg" alt="Thi Ho">
      <h3>Thi Ho</h3>
      <p>Marketing Manager</p>
    </div>
    <div class="team-member">
      <img src="../images/team5.jpg" alt="Isha Dangol">
      <h3>Isha Dangol</h3>
      <p>Sales Director</p>
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

    <p><?php echo nl2br(htmlspecialchars($about_us_content)); ?></p>  
</body>
</html>
