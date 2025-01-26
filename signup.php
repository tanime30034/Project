<?php
    include("php/dbconnection.php");
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $contact_info = $_POST['contact_info'];
        $user_role = $_POST['user_role'];

        $query = mysqli_query($conn,"INSERT INTO users(userName, password, email, role, contactInfo) VALUES('$username','$password','$email','$user_role','$contact_info')");
        if($query)
        {
            $checkQuery = mysqli_query($conn, "SELECT * FROM users WHERE userName = '$username' OR email = '$email'");
            if (mysqli_num_rows($checkQuery) > 0) {
                echo "<script>alert('Username or Email already exists. Please try again with different credentials.');</script>";
            }
            else
            {
            echo"<script>alert('Registration Successful');</script>";
            echo"<script type='text/javascript'> document.location= 'login.html' </script>";
            }
        }
        else
        {
            echo"<script>alert('Error ouccured in registration.Please try again.')";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure the image covers the entire left container */
        .signup-image {
            width: 100%;
            height: 100%; /* Full height of the container */
            object-fit: cover; /* Cover the container fully */
        }
        .form-section {
            padding: 3rem; /* Uniform padding for the form */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center p-0">
        <div class="row w-100 gx-0">
            <!-- Left Section: Image -->
            <div class="col-lg-6 d-none d-lg-flex p-0">
                <img src="images/register-image.jpg" alt="Dog with flower" class="signup-image">
            </div>
            <!-- Right Section: Form -->
            <div class="col-lg-6 col-12 bg-white form-section shadow">
                <div class="text-center mb-4 mt-5">
                    <h1 class="fw-bold">Signup</h1>
                    <p class="text-muted">Please complete the following form.</p>
                </div>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                        <small class="text-muted">Password must be 8-20 characters.</small>
                        <small id="passwordError" class="text-danger d-none">Password must be between 8 and 20 characters.</small>
                    </div>
                    <script>
                        // Get the password input field and error message element
                        const passwordField = document.getElementById('password');
                        const passwordError = document.getElementById('passwordError');
                    
                        // Function to validate password length
                        passwordField.addEventListener('input', function() {
                            const passwordLength = passwordField.value.length;
                            if (passwordLength < 8 || passwordLength > 20) {
                                passwordError.classList.remove('d-none');
                            } else {
                                passwordError.classList.add('d-none');
                            }
                        });
                    </script>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_info" class="form-label">Contact number</label>
                        <input type="tel" class="form-control" id="contact_info" name="contact_info" placeholder="" required>            
                        <small id="contactError" class="text-danger d-none">Enter an 11-digit number without spaces or special characters.</small>
                    </div>
                    <script>
                        // Get the contact number input field and error message element
                        const contactField = document.getElementById('contact_info');
                        const contactError = document.getElementById('contactError');
                    
                        // Function to validate contact number format
                        contactField.addEventListener('input', function() {
                            const contactValue = contactField.value;
                            const isValid = /^\d{11}$/.test(contactValue); // Matches exactly 11 digits
                            if (!isValid) {
                                contactError.classList.remove('d-none');
                            } else {
                                contactError.classList.add('d-none');
                            }
                        });
                    </script>
                    <div class="mb-3">
                        <select class="form-select" id="inlineFormSelectPref" name="user_role" required>
                            <option value="" disabled selected>Choose your role</option>
                            <option value="User">User</optio>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registration</button>
                </form>
                <div class="text-center mt-4">
                    <p>Already have an account? <a href="login.php" class="text-decoration-none text-primary">Login</a></p>
                    <p><a href="index1.html" class="text-decoration-none text-primary">Return without login Home</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
