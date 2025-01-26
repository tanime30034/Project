<?php
session_start();
include_once('../../../php/dbconnection.php'); // Database connection

if (isset($_GET['id'])) {
    $petID = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM pets WHERE petID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $petID);

    if ($stmt->execute()) {
        echo "<script>alert('Pet deleted successfully!'); window.location.href = '../pet_list.php';</script>";
    } else {
        echo "<script>alert('Failed to delete pet: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>