<?php
// Include the database connection file
include('C:/xampp/htdocs/my_pets/php/dbconnection.php');

if (isset($_GET['historyID'])) {
    $historyID = $_GET['historyID'];

    // Fetch the petID associated with the adoption history record
    $fetchSql = "SELECT petID FROM adoption_history WHERE historyID = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $historyID);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result();

    if ($fetchResult->num_rows > 0) {
        $row = $fetchResult->fetch_assoc();
        $petID = $row['petID'];

        // Begin a transaction to ensure both operations succeed or fail together
        $conn->begin_transaction();

        try {
            // Delete the adoption history record
            $deleteSql = "DELETE FROM adoption_history WHERE historyID = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $historyID);
            $deleteStmt->execute();

            // Update the pet's status to 'Available'
            $updateSql = "UPDATE pets SET status = 'Available' WHERE petID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $petID);
            $updateStmt->execute();

            // Commit the transaction
            $conn->commit();

            // Success message
            $message = "Record deleted successfully, and pet status updated to Available";
        } catch (Exception $e) {
            // Rollback the transaction in case of any error
            $conn->rollback();

            // Error message
            $message = "Error deleting record or updating pet status";
        }
    } else {
        // Invalid adoption record
        $message = "Invalid adoption record";
    }
} else {
    // Invalid request
    $message = "Invalid request";
}

// Display the message as a JavaScript alert and redirect
echo "<script>
    alert('" . addslashes($message) . "');
    window.location.href = 'adopter_list.php';
</script>";
?>
