<?php
session_start();
$status = false;
$home = "index1.php";
$redirect = "login.html";

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    $status = true;
    $home = "user_index.php";
    $redirect = "adopter_form.html";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cats - MyPETS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user_index.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <div class="navbar-toggler-container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="images/food.png" alt="Menu" class="navbar-toggler-img">
                </button>
            </div>
            <div class="navbar-logo-container">
                <a class="navbar-brand" href="index1.html">
                    <img src="images/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    <span>MyPETS</span>
                </a>
            </div>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user_index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adopt.php">Adopt Pet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Pet Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Lost & Found</a>
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

    <!-- Content specific to Cats -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="text-dark-purple">Meet Our Cats</h2>
            <div class="row mt-4">
                <!-- Dog profiles go here -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="images/cat_1.jpg" alt="cat 1" class="card-img-top">
                        <div class="card-body bg-purple text-black text-center">
                            <h4>Kitty</h4>
                            <p>Breed : Ginger</p>
                            
                        </div>
                    </div>
                </div>
                <!-- Add more dog profiles as needed -->
            </div>
        </div>
    </section>

    <footer class="footer">
        &copy; 2024 MyPet. All rights reserved.
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>