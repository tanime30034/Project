<?php
session_start();

// Redirect to login if the user is not logged in
$redirect = "adopt_request.php"; // Default action
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    $redirect = "login.html"; // Redirect to login if not logged in
}

// Fetch petID from the query parameter
$petId = isset($_GET['petId']) ? $_GET['petId'] : null;

// Fetch pet details from the database
include("php/dbconnection.php");
$petDetails = [];
if ($petId) {
    $sql = "SELECT * FROM pets WHERE petID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $petDetails = $result->fetch_assoc();
    }
}

// Fetch user details from the session
$userName = $_SESSION['userName'] ?? '';
$userEmail = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Request - MyPETS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Dynamic CSS based on login status -->
    <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
        <link rel="stylesheet" href="css/user_index.css">
    <?php else: ?>
        <link rel="stylesheet" href="css/index1.css">
    <?php endif; ?>
</head>
<body>
    <!-- Navbar -->
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
    
            <!-- Profile Avatar with Dropdown Menu or Login Button -->
            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
                <div class="dropdown">
                    <img src="images/avatar.png" alt="Profile Avatar" class="avatar" id="profileAvatar">
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="profile.html">See Profile</a>
                        <a href="php/logout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.html" class="btn btn-light" id="login">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Form for adoption request -->
    <div class="container mt-5">
        <h2>Adoption Request</h2>
        <form action="<?php echo htmlspecialchars($redirect); ?>" method="post">
            <!-- Input field for petID -->
            <div class="mb-3">
                <label for="petId" class="form-label">Pet ID</label>
                <input type="text" class="form-control" id="petId" name="petId" value="<?php echo htmlspecialchars($petId); ?>">
            </div>

            <!-- User Details -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userName); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>">
            </div>

            <!-- Pet Details (Display Only) -->
            <?php if (!empty($petDetails)): ?>
                <div class="mb-3">
                    <label class="form-label">Pet Details</label>
                    <div class="border rounded shadow-sm mb-4">
                        <!-- Header -->
                        <div class="text-black p-3 rounded-top">
                            <h3 class="mb-0"><?php echo htmlspecialchars($petDetails['name']); ?></h3>
                        </div>
                        <!-- Body -->
                        <div class="p-3">
                            <p class="mb-2"><strong>Breed:</strong> <?php echo htmlspecialchars($petDetails['breed']); ?></p>
                            <p class="mb-2"><strong>Age:</strong> <?php echo htmlspecialchars($petDetails['age']); ?></p>
                            <p class="mb-0"><strong>Description:</strong> <?php echo htmlspecialchars($petDetails['descriptin']); ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Pet details not found.</div>
            <?php endif; ?>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
                    Submit Request
                <?php else: ?>
                    Login to Submit
                <?php endif; ?>
            </button>
        </form>
    </div>

    <footer class="footer">
        &copy; 2024 MyPet. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>