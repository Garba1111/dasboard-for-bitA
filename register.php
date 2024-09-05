<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitcoinamerica";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);  // Plain text password
    $country = $conn->real_escape_string(trim($_POST['country']));
    $referral = isset($_POST['referral']) ? $conn->real_escape_string(trim($_POST['referral'])) : null;

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, country, referral, kyc_status, created_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $country, $referral);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful";
        header('Location: login.php');  // Redirect to login page after successful registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
