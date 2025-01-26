<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // If the user is not logged in, redirect to the login page or show an error
    header("Location: login.php"); // Redirect to login page
    exit;
}

// Database connection (replace with your actual database credentials)
include("php/dbconnection.php");

// Retrieve form data
$petId = $_POST['petId'];
$interested_adopterID = $_SESSION['userID'];
$status = 'Pending';
$submitted_date = date('Y-m-d H:i:s');

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO adoption_request (petID, interested_adopterID, status, submitted_date) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters to the statement
$stmt->bind_param("iiss", $petId, $interested_adopterID, $status, $submitted_date);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>
    alert('Adoption request submitted successfully!');
    window.history.back(); // Redirect back to the previous page
    </script>";
} else {
    echo "<script>
          alert('Error submitting adoption request: " . addslashes($stmt->error) . "');
          window.history.back(); // Redirect back to the previous page
          </script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>