<!DOCTYPE html>
<html lang="en">

<?php include '../includes/header.php'; ?>
<style>
  .pet-image {
    width: 100px; /* Adjust the size as needed */
    height: auto;
    border-radius: 5px; /* Optional: Add rounded corners */
  }
</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include '../includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pet List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- Add New Pet Button -->
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addnew">
                  <span class="glyphicon glyphicon-plus"></span> Add New
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Pet ID</th>
                        <th>Profile Image</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Description</th>
                        <th>Adoption Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Include the database connection file
                      include '../../php/dbconnection.php'; // Adjusted path to dbconnection.php

                      // Fetch data from the pets table
                      $sql = "SELECT * FROM pets";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                          // Output data of each row
                          while($row = $result->fetch_assoc()) {
                              // Construct the image path
                              $imagePath = "function/upload/" . $row["photoPath"]; // Relative path to the upload folder
                              ?>
                              <tr>
                                <td>
                                  <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_<?php echo $row['petID']; ?>">Edit</a>
                                  <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_<?php echo $row['petID']; ?>">Delete</a>
                                </td>
                                <td><?php echo $row["petID"]; ?></td>
                                <td class="text-center">
                                  <img src="<?php echo $imagePath; ?>" class="pet-image" alt="Pet Image">
                                </td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["type"]; ?></td>
                                <td><?php echo $row["breed"]; ?></td>
                                <td><?php echo $row["age"]; ?></td>
                                <td><?php echo $row["descriptin"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                              </tr>

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
                      } else {
                          echo "<tr><td colspan='9'>No pets found</td></tr>";
                      }
                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
 
  </div>
  <!-- /.content-wrapper -->

   <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- Add Pet Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg"> <!-- Modal size set to large -->
        <form method="post" action="function/addPet.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Pet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"> <!-- Row Start -->

                        <!-- First Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pet_name">Pet Name</label>
                                <input class="form-control" type="text" id="pet_name" name="pet_name" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Pet Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" selected disabled>Select Pet Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="breed">Breed</label>
                                <input class="form-control" type="text" id="breed" name="breed" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age (in years)</label>
                                <input class="form-control" type="number" id="age" name="age" min="0" required>
                            </div>
                        </div>
                        <!-- End First Column -->

                        <!-- Second Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Adoption Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="Available">Available</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Adopted">Adopted</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Second Column -->

                        <!-- Third Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="photoPath">Upload Pet Image</label>
                                <input class="form-control-file" type="file" id="photoPath" name="photoPath" accept="image/*" onchange="previewImage()" required>
                            </div>
                            <img id="imagePreview" src="#" alt="Profile Image Preview" style="max-width: 100%; display: none;">
                        </div>
                        <!-- End Third Column -->
                    </div> <!-- End Row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to preview the selected image
    function previewImage() {
        var fileInput = document.getElementById('photoPath');
        var imagePreview = document.getElementById('imagePreview');

        // Check if a file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            // When image file is loaded
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image preview
            };

            // Read the image file
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>

<?php include '../includes/footer.php'; ?>
</body>
</html>