<!-- Edit and Delete Modals -->
<?php
// Include the database connection file
include '../../php/dbconnection.php'; // Adjusted path to dbconnection.php

// Fetch data from the pets table
$sql = "SELECT * FROM pets";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Construct the image path
        $imagePath = "function/upload/" . $row["photoPath"]; // Relative path to the upload folder
        ?>
        <!-- Edit Modal -->
        <div class="modal fade" id="edit_<?php echo $row['petID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Pet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="function/editPet.php" enctype="multipart/form-data">
                            <input type="hidden" name="petID" value="<?php echo $row['petID']; ?>">
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pet_name">Pet Name</label>
                                        <input class="form-control" type="text" name="pet_name" value="<?php echo $row['name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Pet Type</label>
                                        <select class="form-control" name="type" required>
                                            <option value="Dog" <?php echo ($row['type'] == 'Dog') ? 'selected' : ''; ?>>Dog</option>
                                            <option value="Cat" <?php echo ($row['type'] == 'Cat') ? 'selected' : ''; ?>>Cat</option>
                                            <option value="Other" <?php echo ($row['type'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="breed">Breed</label>
                                        <input class="form-control" type="text" name="breed" value="<?php echo $row['breed']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="age">Age (in years)</label>
                                        <input class="form-control" type="number" name="age" value="<?php echo $row['age']; ?>" min="0" required>
                                    </div>
                                </div>
                                <!-- Second Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" required><?php echo $row['descriptin']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Adoption Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="Available" <?php echo ($row['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                            <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Adopted" <?php echo ($row['status'] == 'Adopted') ? 'selected' : ''; ?>>Adopted</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Third Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="photoPath">Upload Pet Image</label>
                                        <input class="form-control-file" type="file" name="photoPath" accept="image/*">
                                        <small>Current file: <?php echo $row['photoPath']; ?></small>
                                    </div>
                                    <img src="<?php echo $imagePath; ?>" class="pet-image" alt="Current Pet Image">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="delete_<?php echo $row['petID']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Pet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Are you sure you want to delete this pet?</p>
                        <h2 class="text-center"><?php echo $row['name']; ?></h2>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="function/deletePet.php?id=<?php echo $row['petID']; ?>" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
$conn->close();
?>