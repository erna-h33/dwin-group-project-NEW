<?php
session_start();
require '../config.php'; 

// Ensure the user is logged in as a customer
if ($_SESSION['user_role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

$customer_name = $_SESSION['user_name'];  
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE COMMERCIAL Real Estate</title>
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

    <section class="hero">
      <div class="hero-content">
        <h2>Your Trusted Real Estate Agency</h2>
        <p>
          We assist you with all your buying, selling, renting, and leasing
          needs.
        </p>
        <a href="customer_view_properties.php" class="cta-button hero-button"
          >View Properties</a
        >
      </div>
    </section>

    <main>
      <!-- About Us Section -->
      <section class="about-us dark-bg">
        <div class="about-content">
          <div class="about-text-container">
            <h2 class="light-gold-text">About Us</h2>
            <p class="light-gold-text">
              CORE COMMERCIAL Real Estate has been a leader in the Northern and
              Western Suburbs, offering unparalleled services for buying,
              selling, renting, and leasing properties. Our team of experts is
              dedicated to delivering a personalized experience, ensuring that
              each client receives the utmost care and attention in their real
              estate journey.<br /><br />
            </p>
            <p class="light-gold-text">
              With a commitment to integrity, professionalism, and continuous
              learning, we stay ahead in the dynamic market landscape. Our
              collaborative approach allows us to cater to diverse needs, be it
              commercial or residential properties. At CORE COMMERCIAL, we are
              not just about transactions; we build relationships that last.
            </p>
            <a href="about_us.php" class="cta-button button-outline">Read More</a>
          </div>
          <div class="about-image">
            <img
              src="../images/about-us.jpg"
              alt="About CORE COMMERCIAL Real Estate"
            />
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section class="services">
        <div class="container">
          <h2>Our Services</h2>
          <div class="service-boxes">
            <div class="service-box">
              <i class="fas fa-home fa-3x service-icon"></i>
              <h4 class="light-gold-text">Buying & Selling</h4>
              <p class="light-gold-text">
                Navigating the real estate market can be complex, whether you’re
                buying your dream property or selling. Our expert team guides
                you through each step, offering market analysis, and tailored
                property searches. With our focus on transparency and
                professionalism, we ensure a seamless and successful experience
                for both buyers and sellers.
              </p>
            </div>
            <div class="service-box">
              <i class="fas fa-building fa-3x service-icon"></i>
              <h4 class="light-gold-text">Property Management</h4>
              <p class="light-gold-text">
                Property management can be demanding, but our services take the
                stress off your shoulders. From tenant screening and lease
                management to maintenance and rent collection, we handle every
                detail. Regular inspections and compliance with local
                regulations help maintain your property's value, providing you
                peace of mind while fostering positive tenant relationships.
              </p>
            </div>
            <div class="service-box">
              <i class="fas fa-key fa-3x service-icon"></i>
              <h4 class="light-gold-text">Leasing & Renting</h4>
              <p class="light-gold-text">
                Finding the right rental space is effortless with our tailored
                leasing services. Whether for commercial or residential needs,
                we offer a comprehensive portfolio, detailed property viewings,
                and expert negotiation support. Our goal is to secure a space
                that meets your requirements and supports your growth and
                success.
              </p>
            </div>
            <div class="service-box">
              <i class="fas fa-chart-line fa-3x service-icon"></i>
              <h4 class="light-gold-text">Investment Consultation</h4>
              <p class="light-gold-text">
                Our investment consultation service is designed to help you
                navigate the market confidently. We offer tailored strategies
                based on market trends, property value analysis, and long-term
                growth potential. Our experts work with you to identify
                high-return opportunities and guide you in making informed
                decisions that align with your financial goals.
              </p>
            </div>
            <div class="service-box">
              <i class="fas fa-balance-scale fa-3x service-icon"></i>
              <h4 class="light-gold-text">Property Valuation</h4>
              <p class="light-gold-text">
                Accurate property valuation is crucial whether you’re planning
                to sell, invest, or simply assess your assets. Our team provides
                in-depth valuation services, considering market conditions,
                location, and property features to give you a comprehensive
                understanding of your property's worth. With our valuation
                expertise, you can make well-informed decisions with clarity and
                confidence.
              </p>
            </div>
            <div class="service-box">
              <i class="fas fa-truck-moving fa-3x service-icon"></i>
              <h4 class="light-gold-text">Relocation Services</h4>
              <p class="light-gold-text">
                Relocating can be a daunting process, but our comprehensive
                relocation services make it hassle-free. We handle everything
                from finding the perfect property that suits your lifestyle to
                managing logistics for a smooth move. Our team provides
                personalized support, ensuring that your transition to a new
                home or office is efficient, stress-free, and tailored to your
                needs.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Property Listings Section -->
      <!-- <section class="properties-listings">
        <h2>Our Property Listings</h2>
        <div class="property-boxes">
          <div class="property-box">
            <h3>Commercial Office Space</h3>
            <p>Location: Melbourne CBD</p>
            <p>Price: $500,000</p>
          </div>
          <div class="property-box">
            <h3>Residential Apartment</h3>
            <p>Location: South Morang</p>
            <p>Price: $350,000</p>
          </div>
          <div class="property-box">
            <h3>Retail Space</h3>
            <p>Location: Footscray</p>
            <p>Price: $750,000</p>
          </div>
        </div>
      </section> -->

      <!-- Contact Us Section -->
      <section class="contact-us">
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
      </section>

      <!-- Existing CTA Section -->
      <section class="cta-section">
        <h2>Ready to Find Your Next Property?</h2>
        <a href="customer_view_properties.php" class="cta-button">View Properties List</a>
      </section>
    </main>

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
<!-- <body>

    <div class="navbar">
        <a href="customer_home.php">Home</a>
        <a href="customer_profile.php">Profile</a>
        <a href="about_us.php">About Us</a>
        <a href="contact_us.php">Contact Us</a>
        <a href="customer_view_properties.php">View Properties</a>
        <a href="customer_logout.php">Logout</a>
    </div>

    <div class="welcome-message">
        <h1>Welcome, <?php echo htmlspecialchars($customer_name); ?>!</h1>
        <p>Welcome to your dashboard! You can use the navigation bar to manage your profile or browse available properties.</p>
    </div>

</body> -->
</html>
