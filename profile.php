<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPETS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="user_index.css">
</head>
<body>
    <?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['userID'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Fetch user details from the session
    $userID = $_SESSION['userID'];
    $username = $_SESSION['userName'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['contactinfo'];
    ?>

    <!-- Navbar (unchanged) -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <!-- Navbar Toggle (on the left) -->
            <div class="navbar-toggler-container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- Use the image URL from Flaticon directly -->
                    <img src="images/food.png" alt="Menu" class="navbar-toggler-img">
                </button>
            </div>
            
            <!-- Logo in the center -->
            <div class="navbar-logo-container">
                <a class="navbar-brand" href="user_index.php">
                    <img src="images/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    <span>MyPETS</span>
                </a>
            </div>
    
            <!-- Navbar Items -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user_index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adopt.php">Adopt Pet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Pet Care</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active no-arrow" href="#" id="lostFoundDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Lost & Found
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="lostFoundDropdown">
                            <li><a class="dropdown-item" href="report_lost_pet.html">Report Lost Pet</a></li>
                            <li><a class="dropdown-item" href="lost-found.html">View Listings</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Pet Accessories</a>
                    </li>
                </ul>
            </div>
    
            <!-- Profile Avatar with Dropdown Menu --> 
            <div class="dropdown"> 
                <img src="images/avatar.png" alt="Profile Avatar" class="avatar" id="profileAvatar"> 
                <div class="dropdown-content" id="dropdownContent"> 
                    <a href="profile.html">See Profile</a> 
                    <a href="php/logout.php">Logout</a> 
                </div> 
            </div>

            <script>
            // Toggle the dropdown menu
            document.getElementById('profileAvatar').addEventListener('click', function() {
              var dropdownContent = document.getElementById('dropdownContent');
              if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
                 dropdownContent.style.display = "block";
              } else {
              dropdownContent.style.display = "none";
                        }
            });

            // Hide the dropdown menu when clicking outside of it
            window.onclick = function(event) {
            if (!event.target.matches('.avatar')) {
              var dropdownContent = document.getElementById('dropdownContent');
             if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
                    }
                }
            }
            </script>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-4">User Profile</h2>
        <div class="profile-details bg-light p-4 rounded shadow">
            <!-- Display User Details in Text Boxes -->
            <div class="mb-3">
                <label for="userID" class="form-label"><strong>UserID:</strong></label>
                <input type="text" class="form-control" id="userID" value="<?php echo htmlspecialchars($userID); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label"><strong>Username:</strong></label>
                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email:</strong></label>
                <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label"><strong>Phone:</strong></label>
                <input type="tel" class="form-control" id="phone" value="<?php echo htmlspecialchars($phone); ?>" readonly>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light mt-5">
        &copy;2025 My Pet. All Rights Reserved.
    </footer>

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>