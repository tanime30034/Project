<?php
    session_start();
    $redirects = [
        'adopt' => "adopt.php",
        'petCare' => "login.html",
        'lost&found' => "lost-found.html",
        'petAccessories' => "login.html",

        'dogs' => "dogs.php",
        'cats' => "cats.php",

        'buttonText' => "Login",
        'buttonLink' => "login.html",
    ];
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
    {
        $redirects['adopt'] = "adopt.php";
        $redirects['dogs'] = "dogs.php";
        $redirects['cats'] = "cats.php";
        $redirects['buttonText'] = "Logout";
        $redirects['buttonLink'] = "php/logout.php";
    }
    include("php/dbconnection.php");

    // Fetch pet names and photo paths from the pets table, limit to 3 pets
    $sql = "SELECT petID, name, photoPath FROM pets WHERE status='Available' LIMIT 3";
    $result = $conn->query($sql);
    $pets = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
    } else {
        $pets = [["name" => "No pets available", "photoPath" => "images/default.jpg"]];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPETS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index1.css">
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
                <a class="navbar-brand" href="index1.php">
                    <img src="images/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    <span>MyPETS</span>
                </a>
            </div>
    
            <!-- Navbar Items -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index1.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adopt.php">Adopt Pet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pet_help_desk.html">Pet Care</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="lost_found1.html">Lost & Found</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pet_accesories.html">Pet Accessories</a>
                    </li>
                </ul>
            </div>
    
            <!-- Login/Logout Button -->
            <a href="<?=$redirects['buttonLink']?>" class="btn btn-light" id="login">
                <?=$redirects['buttonText']?>
            </a>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slider_1.jpg" class="d-block w-100" alt="Slider 1">
            </div>
            <div class="carousel-item">
                <img src="images/slider_2.jpg" class="d-block w-100" alt="Slider 2">
            </div>
            <div class="carousel-item">
                <img src="images/slider_3.jpg" class="d-block w-100" alt="Slider 3">
            </div>
        </div>
    </div>
    <!--Cats and Dogs-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="text-dark-purple">Adopt Your New Best Friend</h2>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-3 col-sm-6 text-center">
                    <div class="option">
                        <!-- Wrap the whole div inside an <a> tag for clickable area -->
                        <a href="<?=$redirects['dogs']?>">
                            <img src="images/dog.png" alt="Dogs" class="mb-3 img-fluid" style="max-width: 100px;">
                            <p class="text-dark">Dogs</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 text-center">
                    <div class="option">
                        <!-- Wrap the whole div inside an <a> tag for clickable area -->
                        <a href="<?=$redirects['cats']?>">
                            <img src="images/cat.png" alt="Cats" class="mb-3 img-fluid" style="max-width: 100px;">
                            <p class="text-dark">Cats</p>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <!-- Featured Pets -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="text-dark-purple">Featured Pets</h2>
            <div class="row justify-content-center mt-4">
                <?php
                foreach ($pets as $pet) {
                    echo '<div class="col-md-4 col-sm-6 d-flex justify-content-center">
                            <a href="adopter_form.php?petId=' . $pet['petID'] . '" style="text-decoration: none; color: inherit;">
                                <div class="card" style="width: 18rem;">
                                    <img src="pages/pet/function/upload/' . $pet['photoPath'] . '" alt="' . $pet['name'] . '" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body bg-purple text-black text-center">
                                        ' . $pet['name'] . '
                                    </div>
                                </div>
                            </a>
                        </div>';
                }
                ?>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container text-center">
            <h2 class="text-dark-purple">Our Services</h2>
            <div class="row justify-content-center mt-3">
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="<?=$redirects['adopt']?>" style="text-decoration: none; color: inherit;"> 
                        <div class="card">
                            <img src="images/adopt_process_1.jpg" alt="Pet 1" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-purple text-black text-center">
                                <h4>Adopt a Pet</h4>
                            </div>
                        </div>
                    </a> 
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="<?=$redirects['lost&found']?>" style="text-decoration: none; color: inherit;"> 
                        <div class="card">
                            <img src="images/adopt_process_2.jpg" alt="Pet 1" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-purple text-black text-center">
                                <h4>Find Your Pet</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="<?=$redirects['petCare']?>" style="text-decoration: none; color: inherit;"> 
                        <div class="card">
                            <img src="images/adopt_process_3.jpg" alt="Pet 1" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-purple text-black text-center">
                                <h4>Pet Care</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="pet_accesories.html" style="text-decoration: none; color: inherit;"> 
                        <div class="card">
                            <img src="images/pet_foodz.jpg" alt="Pet 1" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-purple text-black text-center">
                                <h4>Pet Products</h4>
                            </div>
                        </div>
                    </a>
                </div>
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