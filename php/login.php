<?php
session_start();
include("dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE userName= ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $password) {
            // Successful login
            $_SESSION['loggedIn'] = true;
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['userName'] = $username;
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['contactinfo'] = $row['contactInfo'];

            if($_SESSION['role']=="Admin")
            {
            header("Location: dashboard.php");
            exit();
            }
            else
            {
            header("Location: ../user_index.php");
            exit();
            }
        } else {
            // Password mismatch
            $error = 'Invalid username or password.';
        }
    } else {
        // Username not found
        $error = 'Invalid username or password.';
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the login page with an error message
    header("Location: ../login.html?error=" . urlencode($error));
    exit();
}
?>
