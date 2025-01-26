<?php
// editAdopter.php

// Include database connection
include('C:/xampp/htdocs/my_pets/php/dbconnection.php');

// Check if the form is submitted
if (isset($_POST['edit'])) {
    // Get form data
    $adopter_id = $_POST['adopter_id'];
    $pet_id = $_POST['pet_id'];
    $adoption_date = $_POST['adoption_date'];

    // Validate input
    if (empty($adopter_id) || empty($pet_id) || empty($adoption_date)) {
        echo "<script>
                alert('All fields are required.');
                window.location.href='../adopter_list.php';
              </script>";
        exit();
    }

    // 1. Check if the adopter exists
    $query = "SELECT * FROM users WHERE userID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adopter_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
                alert('Adopter does not exist.');
                window.location.href='../adopter_list.php';
              </script>";
        exit();
    }
    $stmt->close();

    // 2. Check if the pet exists
    $query = "SELECT * FROM pets WHERE petID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
                alert('Pet does not exist.');
                window.location.href='../adopter_list.php';
              </script>";
        exit();
    }
    $stmt->close();

    // 3. Check if the pet is available for adoption
    $query = "SELECT status FROM pets WHERE petID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['status'] !== 'available') {
        echo "<script>
                alert('Pet is not available for adoption.');
                window.location.href='../adopter_list.php';
              </script>";
        exit();
    }
    $stmt->close();

    // If all validations pass, update the adoption date
    $query = "UPDATE adoptions SET adoption_date = ? WHERE adopter_id = ? AND pet_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $adoption_date, $adopter_id, $pet_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Adoption details updated successfully.');
                window.location.href='../adopter_list.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update adoption details.');
                window.location.href='../adopter_list.php';
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href='../adopter_list.php';
          </script>";
    exit();
}
?>
