<?php
// Start session
session_start();

// Database configuration
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "bitcoinamerica"; // Your database name

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize error variable
$error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT password, is_admin FROM users WHERE email = ?");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters and execute the query
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $isAdmin);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables and redirect to the appropriate page
            $_SESSION["email"] = $email;
            $_SESSION["is_admin"] = $isAdmin;

            if ($isAdmin) {
                header("Location: dashboardadmin_dashboard.php");
                exit();
            } else {
                header("Location: dashboard/index.php");
                exit();
            }
        } else {
            $error = "Wrong password. Please try again.";
        }
    } else {
        $error = "Email not registered. Please check your email or register.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Bitcoin America</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/bitcoin.png" rel="icon">
  <link href="assets/img/bitcoin.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">


  
  
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/bitcoin.png" alt="">
        <h1 class="sitename">BitcoinAmerica</h1>
      </a>
      

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html#hero" class="active">Home</a></li>
          <li><a href="index.html#about">About</a></li>
          <li><a href="index.html#features">Features</a></li>
          <li><a href="index.html#services">Services</a></li>
          <li><a href="index.html#pricing">Pricing</a></li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="index.html#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="register.html">Register</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <video autoplay muted loop playsinline class="hero-video">
          <source src="videos/video.mp4" type="video/mp4">
          
        </video>
      </div>
      
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center hero-content">
          <h1 id="interactive-heading" data-aos="fade-up">Create Your Account</h1>
          <p data-aos="fade-up" data-aos-delay="100">
            Empower your investments with cutting-edge Bitcoin strategies and solutions.
          </p>
      
       <!-- LOGIN Form Section -->
    <div class="form-container" data-aos="fade-up" data-aos-delay="200">
        <!-- LOGIN Form -->
        <form action="login.php" method="post" class="login-form">
            <!-- Form Heading -->
            <h2 class="form-heading">Login</h2>

            <!-- Email Address Field -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Forgot Password Link -->
            <div class="form-group text-center">
                <a href="forgot-password.html" class="forgot-password-link">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Login</button>

            <!-- Register Link -->
            <div class="mt-4">
                <p>Don't have an account? <a href="register.html" class="register-link">Register here</a></p>
            </div>
            
            <!-- Display Error Message -->
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
            
          </div>
        </div>
      </div>
      
      <style>
        /* Container for the form */
        .form-container {
          width: 100%;
          max-width: 600px; /* Maximum width */
          height: 490px; /* Adjusted height */
          margin: 0 auto; /* Center align */
          padding: 2rem; /* Padding for spacing */
          background-color: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
          border-radius: 12px; /* Rounded corners */
          box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Subtle shadow */
          overflow-y: auto; /* Add scroll if content overflows */
        }
      
        /* Style for form heading */
        .form-heading {
          font-size: 1.75rem; /* Larger font size */
          font-weight: 700; /* Bold */
          color: #333; /* Dark text color */
          margin-bottom: 1rem; /* Space below heading */
        }
      
        /* Style for form labels */
        .form-label {
          font-weight: 600; /* Bold */
          font-size: 0.875rem; /* Smaller font size */
          color: #444; /* Dark grey color */
          display: block; /* Ensures label takes up full width */
          margin-bottom: 0.5rem; /* Space below label */
          text-align: left; /* Align text to the left */
        }
      
        /* Style for form controls */
        .form-control, .form-select {
          height: 2.5rem; /* Adjust height */
          border-radius: 6px; /* Rounded corners */
          box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle inner shadow */
          border: 1px solid #ddd; /* Light border */
          margin-top: 0.25rem; /* Space above input */
          padding: 0.5rem; /* Padding inside input */
          font-size: 0.875rem; /* Smaller font size */
        }
      
        /* Lighter placeholder text */
        .form-control::placeholder {
          color: #aaa; /* Light grey color */
          opacity: 1; /* Ensure placeholder is visible */
        }
      
        /* Style for primary button with Bitcoin color */
        .btn-primary {
          background-color: #f7931a; /* Bitcoin color */
          border-color: #f7931a; /* Bitcoin color */
          border-radius: 6px; /* Rounded corners */
          padding: 0.75rem 1.5rem; /* Adjust padding */
          font-size: 0.875rem; /* Smaller font size */
          color: #fff; /* White text */
          cursor: pointer;
          transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }
      
        /* Button hover effect */
        .btn-primary:hover {
          background-color: #e78b1e; /* Slightly darker Bitcoin color */
          border-color: #e78b1e; /* Slightly darker Bitcoin color */
        }
      
        /* Style for checkbox container */
        .checkbox-container {
          display: flex;
          align-items: center; /* Align items in the center vertically */
          justify-content: center; /* Center align horizontally */
          margin-top: 0.5rem; /* Space above checkbox */
        }
      
        /* Style for form-check input */
        .form-check-input {
          margin-right: 0.5rem; /* Space between checkbox and label */
          vertical-align: middle; /* Align checkbox vertically with text */
        }
      
        /* Style for form-check label */
        .form-check-label {
          font-size: 0.75rem; /* Smaller font size */
          color: #444; /* Dark grey color */
        }
      
        /* Style for terms link */
        .terms-link {
          color: #f7931a; /* Bitcoin color */
          text-decoration: none;
        }
      
        .terms-link:hover {
          text-decoration: underline;
        }
      
        /* Style for login link */
        .login-link {
          color: #f7931a; /* Bitcoin color */
          text-decoration: none;
        }
      
        .login-link:hover {
          text-decoration: underline;
        }
      </style>
      
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const countrySelect = document.getElementById('country');
          const countries = [
            'United States', 'Canada', 'United Kingdom', 'Australia', 'Germany',
            'France', 'Italy', 'Spain', 'Netherlands', 'Brazil', 'India', 'China',
            'Japan', 'South Korea', 'Mexico', 'Russia', 'South Africa', 'Saudi Arabia',
            'Turkey', 'Switzerland', 'Sweden', 'New Zealand'
            // Add more countries as needed
          ];
      
          countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country;
            option.textContent = country;
            countrySelect.appendChild(option);
          });
        });
      </script>
      
       
    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
  

<footer id="footer" class="footer position-relative light-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">QuickStart</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Your Company Address</p>
          <p>City, Country</p>
          <p class="mt-3"><strong>Phone:</strong> <span>+1 234 567 8900</span></p>
          <p><strong>Email:</strong> <span>support@yourcompany.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href="https://twitter.com/yourcompany" target="_blank"><i class="bi bi-twitter"></i></a>
          <a href="https://facebook.com/yourcompany" target="_blank"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com/yourcompany" target="_blank"><i class="bi bi-instagram"></i></a>
          <a href="https://linkedin.com/company/yourcompany" target="_blank"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Investment Plans</a></li>
          <li><a href="#">Trading Tools</a></li>
          <li><a href="#">Portfolio Management</a></li>
          <li><a href="#">Market Insights</a></li>
          <li><a href="#">Customer Support</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12 footer-newsletter">
        <h4>Our Newsletter</h4>
        <p>Subscribe to our newsletter for the latest updates and insights on Bitcoin investment opportunities!</p>
        <form action="forms/newsletter.php" method="post" class="php-email-form">
          <div class="newsletter-form"><input type="email" name="email" placeholder="Your Email"><input type="submit" value="Subscribe"></div>
          <div class="loading">Loading</div>
          <div class="error-message"></div>
          <div class="sent-message">Your subscription request has been sent. Thank you!</div>
        </form>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">BitcoinAmerica</strong><span>All Rights Reserved</span></p>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">Thegreattech</a>
    </div>
  </div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  
</body>

</html>