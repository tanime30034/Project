<?php
session_start();
include("php/dbconnection.php");
$status = false;
$home = "index1.php";
$redirect = "login.html";

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    $status = true;
    $home = "user_index.php";
    $redirect = "adopter_form.html";
}
// Fetch pet data from the database
$sql = "SELECT * FROM pets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt My Pets</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user_index.css">
    <style>
        .card-img-top {
        width: 100%;
        height: 250px; 
        object-fit: cover;
        }
        .no-arrow::after {
        display: none;
        }
    </style>
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
                <a class="navbar-brand" href="<?=$home?>">
                    <img src="images/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    <span>MyPETS</span>
                </a>
            </div>
    
            <!-- Navbar Items -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=$home?>">Home</a>
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
    
            <!-- Profile Avatar or Login Button --> 
            <?php if($status) { ?>
                <div class="dropdown"> <img src="images/avatar.png" alt="Profile Avatar" class="avatar" id="profileAvatar"> 
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
            <?php } else { ?>
                <a href="login.html" class="btn btn-light" id="login">
                    Login
                </a>
            <?php } ?>
        </div>
    </nav>

<!-- Content Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="text-dark-purple">Adopt Your Best Friend</h2>
        <div class="row mt-4">
            <!-- Dynamically Generate Pet Profiles -->
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="<?=$redirect?>" class="card shadow-sm text-decoration-none">
                        <!-- Image Section -->
                        <img src="pages/pet/function/upload/<?=htmlspecialchars($row['photoPath'])?>" alt="Featured Pet" class="card-img-top">
                        <div class="card-body bg-purple text-black text-center">
                            <h3 class="h5"><?= htmlspecialchars($row['name']) ?></h3>
                            <p class="mb-1"><strong>Breed:</strong> <?= htmlspecialchars($row['breed']) ?></p>
                            <p class="mb-1"><strong>Age:</strong> <?= htmlspecialchars($row['age']) ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p class="text-center text-muted">No pets available for adoption at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="footer">
        &copy; <?= date('Y') ?> MyPet. All rights reserved.
    </footer>

     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
