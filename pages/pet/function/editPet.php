<?php
session_start();
include_once('../../../php/dbconnection.php'); // Database connection

if (isset($_POST['edit'])) {
    $petID = $_POST['petID'];
    $petName = $_POST['pet_name'];
    $type = $_POST['type'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Handle image upload
    if (!empty($_FILES['photoPath']['name'])) {
        $targetDirectory = "upload/"; // Relative path to the upload folder
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
        }

        // Update query with new image
        $sql = "UPDATE pets SET name=?, type=?, breed=?, age=?, descriptin=?, status=?, photoPath=? WHERE petID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssi", $petName, $type, $breed, $age, $description, $status, $imageName, $petID);
    } else {
        // Update query without changing the image
        $sql = "UPDATE pets SET name=?, type=?, breed=?, age=?, descriptin=?, status=? WHERE petID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $petName, $type, $breed, $age, $description, $status, $petID);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Pet updated successfully!'); window.location.href = '../pet_list.php';</script>";
    } else {
        echo "<script>alert('Failed to update pet: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>