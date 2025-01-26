<?php
session_start();
include_once('../../../php/dbconnection.php'); // Database connection

if (isset($_POST['add'])) {
    // Validate required fields and file
    $requiredFields = ['pet_name', 'type', 'breed', 'age', 'description', 'status'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo "<script>alert('Please fill out all required fields.'); window.history.back();</script>";
            exit();
        }
    }

    if (empty($_FILES['photoPath']['name'])) {
        echo "<script>alert('Please upload a pet photo.'); window.history.back();</script>";
        exit();
    }

    // Handle image upload
    $targetDirectory = "upload/"; // Corrected relative path
    $imageFileType = strtolower(pathinfo($_FILES["photoPath"]["name"], PATHINFO_EXTENSION));
    $imageName = uniqid() . "." . $imageFileType;
    $targetFile = $targetDirectory . $imageName;

    // Validate image
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.'); window.history.back();</script>";
        exit();
    } elseif ($_FILES["photoPath"]["size"] > 5000000) {
        echo "<script>alert('File size exceeds 5MB.'); window.history.back();</script>";
        exit();
    } elseif (!move_uploaded_file($_FILES["photoPath"]["tmp_name"], $targetFile)) {
        echo "<script>alert('Error uploading file.'); window.history.back();</script>";
        exit();
    } else {
        // Insert into database
        $sql = "INSERT INTO pets (name, type, breed, age, descriptin, photoPath, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisss", $_POST['pet_name'], $_POST['type'], $_POST['breed'], $_POST['age'], $_POST['description'], $imageName, $_POST['status']);

        if ($stmt->execute()) {
            echo "<script>alert('Successfully added a new pet!'); window.location.href = '../pet_list.php';</script>";
        } else {
            echo "<script>alert('Failed to add pet: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        }
        $stmt->close();
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit();
}
?>