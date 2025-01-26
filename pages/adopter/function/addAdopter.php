<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('C:/xampp/htdocs/my_pets/php/dbconnection.php');

if (isset($_POST['add'])) {
    // Get form data
    $userID = $_POST['userID'];
    $petID = $_POST['petID'];
    $adoption_date = $_POST['adoption_date'];

    // Validate inputs
    if (empty($userID) || empty($petID) || empty($adoption_date)) {
        echo "<script>alert('Please fill all fields.'); window.location.href='../adopter_list.php';</script>";
        exit();
    }

    // Check if the user exists
    $userCheckQuery = "SELECT userID FROM users WHERE userID = ?";
    $userCheckStmt = $conn->prepare($userCheckQuery);
    $userCheckStmt->bind_param("i", $userID);
    $userCheckStmt->execute();
    $userCheckResult = $userCheckStmt->get_result();

    if ($userCheckResult->num_rows == 0) {
        echo "<script>alert('User does not exist.'); window.location.href='../adopter_list.php';</script>";
        exit();
    }

    // Check if the pet exists
    $petCheckQuery = "SELECT petID FROM pets WHERE petID = ?";
    $petCheckStmt = $conn->prepare($petCheckQuery);
    $petCheckStmt->bind_param("i", $petID);
    $petCheckStmt->execute();
    $petCheckResult = $petCheckStmt->get_result();

    if ($petCheckResult->num_rows == 0) {
        echo "<script>alert('Pet does not exist.'); window.location.href='../adopter_list.php';</script>";
        exit();
    }

    // Check if the pet is available for adoption
    $availabilityQuery = "SELECT petID FROM pets WHERE petID = ? AND status = 'Available'";
    $availabilityStmt = $conn->prepare($availabilityQuery);
    $availabilityStmt->bind_param("i", $petID);
    $availabilityStmt->execute();
    $availabilityResult = $availabilityStmt->get_result();

    if ($availabilityResult->num_rows == 0) {
        echo "<script>alert('This pet is not available for adoption.'); window.location.href='../adopter_list.php';</script>";
        exit();
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into adoption_history table
        $adoptionInsertQuery = "INSERT INTO adoption_history (adopterID, petID, adoption_date) VALUES (?, ?, ?)";
        $adoptionInsertStmt = $conn->prepare($adoptionInsertQuery);
        $adoptionInsertStmt->bind_param("iis", $userID, $petID, $adoption_date);
        $adoptionInsertStmt->execute();

        // Update the pet's status to 'Adopted'
        $updatePetQuery = "UPDATE pets SET status = 'Adopted' WHERE petID = ?";
        $updatePetStmt = $conn->prepare($updatePetQuery);
        $updatePetStmt->bind_param("i", $petID);
        $updatePetStmt->execute();

        // Commit the transaction
        $conn->commit();

        echo "<script>alert('Adoption record added successfully.'); window.location.href='../adopter_info.php';</script>";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='../adopter_info.php';</script>";
    }

    // Close statements and connection
    $adoptionInsertStmt->close();
    $updatePetStmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid access.'); window.location.href='../adopter_info.php';</script>";
}
?>
