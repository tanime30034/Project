<?php
// Include database connection
include('../../php/dbconnection.php');

if (isset($_GET['id'])) {
    $historyID = $_GET['id']; 

    //Fetch the current adopter details using historyID
    $query = "SELECT ah.petID, u.userName, ah.adoption_date FROM adoption_history ah
              JOIN users u ON u.userID = ah.adopterID
              WHERE ah.historyID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $historyID); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch adopter and pet details
        $row = $result->fetch_assoc();
        $adopterName = $row['userName'];
        $oldPetID = $row['petID'];
        $adoptionDate = $row['adoption_date'];
    } else {
        echo "<script>alert('Adoption record not found.'); window.location.href='../adopter_list.php';</script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>alert('No historyID provided.'); window.location.href='../adopter_list.php';</script>";
    exit();
}

// Handle the form submission to update adopter details
if (isset($_POST['submit'])) {
    // Get the form data
    $userName = $_POST['userName'];
    $newPetID = $_POST['petID'];
    $adoptionDate = $_POST['adoptionDate'];

    // Check if the adopter exists in the users table
    $userQuery = "SELECT userID FROM users WHERE userName = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $resultUser = $stmt->get_result();

    if ($resultUser->num_rows == 0) {
        echo "<script>alert('Adopter with the username \"$userName\" does not exist.'); window.location.href='editAdopter.php?id=$historyID';</script>";
        exit();
    }

    $userRow = $resultUser->fetch_assoc();
    $adopterID = $userRow['userID'];  // Get the adopter ID

    //Check if the new pet exists using the new petID
    $petQuery = "SELECT petID, status FROM pets WHERE petID = ?";
    $stmt = $conn->prepare($petQuery);
    $stmt->bind_param("i", $newPetID);  // Bind the new petID as integer
    $stmt->execute();
    $resultPet = $stmt->get_result();

    if ($resultPet->num_rows == 0) {
        echo "<script>alert('Pet with the ID \"$newPetID\" does not exist.'); window.location.href='editAdopter.php?id=$historyID';</script>";
        exit();
    }

    $petRow = $resultPet->fetch_assoc();
    $petStatus = $petRow['status'];

    //Check if the new pet is already adopted
    if ($petStatus == 'adopted') {
        echo "<script>alert('This pet has already been adopted.'); window.location.href='editAdopter.php?id=$historyID';</script>";
        exit();
    }

    //Update the adoption record in adoption_history table using historyID
    $updateQuery = "UPDATE adoption_history SET petID = ?, adopterID = ?, adoption_date = ? WHERE historyID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("iisi", $newPetID, $adopterID, $adoptionDate, $historyID);

    if ($stmt->execute()) {
        //  If the new pet was adopted, update its status to "Adopted"
        if ($petStatus !== 'adopted') {
            $updateStatusQuery = "UPDATE pets SET status = 'Adopted' WHERE petID = ?";
            $stmtUpdate = $conn->prepare($updateStatusQuery);
            $stmtUpdate->bind_param("i", $newPetID);
            if ($stmtUpdate->execute()) {
                // If the old pet was still in the "adopted" status, change its status to "available"
                if ($oldPetID !== $newPetID) {
                    $updateOldPetStatusQuery = "UPDATE pets SET status = 'Available' WHERE petID = ?";
                    $stmtOldPetUpdate = $conn->prepare($updateOldPetStatusQuery);
                    $stmtOldPetUpdate->bind_param("i", $oldPetID);
                    $stmtOldPetUpdate->execute();
                }

                // Success: Redirect to the adopter list after the successful update
                echo "<script>alert('Adoption Record Updated Successfully!'); window.location.href='../adopter/adopter_list.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error: Could not update pet status.'); window.location.href='editAdopter.php?id=$historyID';</script>";
            }
        } else {
            echo "<script>alert('Adoption Record Updated Successfully!'); window.location.href='../adopter/adopter_list.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: Could not update adoption record.'); window.location.href='editAdopter.php?id=$historyID';</script>";
    }

    // Close the statement
    $stmt->close();
    $stmtUpdate->close();
    $stmtOldPetUpdate->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Adoption Record</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For icons -->
    <style>
       
        body {
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            min-height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0984e3;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 20px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #0984e3;
            border: none;
        }
        .btn-primary:hover {
            background-color: #74b9ff;
        }
        .container {
            padding: 50px 0;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
    <script>
        // JavaScript to ensure the form submission is valid
        function validateForm() {
            const userName = document.getElementById('userName').value;
            const petID = document.getElementById('petID').value;
            const adoptionDate = document.getElementById('adoptionDate').value;
            if (!userName || !petID || !adoptionDate) {
                alert('All fields are required.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <div class="form-container">
        <div class="card">
            <div class="card-header">
                <h2>Edit Adoption Record</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="editAdopter.php?id=<?php echo $historyID; ?>" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="userName" class="form-label"><i class="fas fa-user"></i> Adopter Name:</label>
                        <input type="text" name="userName" id="userName" class="form-control" value="<?php echo htmlspecialchars($adopterName); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="petID" class="form-label"><i class="fas fa-paw"></i> Pet ID:</label>
                        <input type="text" name="petID" id="petID" class="form-control" value="<?php echo htmlspecialchars($oldPetID); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="adoptionDate" class="form-label"><i class="fas fa-calendar-check"></i> Adoption Date:</label>
                        <input type="date" name="adoptionDate" id="adoptionDate" class="form-control" value="<?php echo htmlspecialchars($adoptionDate); ?>" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Adoption Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
