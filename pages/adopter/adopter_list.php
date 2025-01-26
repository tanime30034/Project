<!DOCTYPE html>
<html lang="en">

<?php include '../includes/header.php'; ?>
<style>
  .hidden-column {
    display: none;
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
            <h1>Adopter Info</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
      <?php include '../includes/success_message.php'; ?>
      <?php include '../includes/error_message.php'; ?>
      <?php include 'add_modal.php'; ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th class='hidden-column'>Adopter ID</th>
                        <th>Adopter Name</th>
                        <th>Email Address</th> 
                        <th>Contact Number</th>
                        <th>Pet Name</th>
                        <th>Pet Image</th>
                        <th>Adoption Date</th> <!-- New column for adoption date -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Include the database connection file
                        include('C:/xampp/htdocs/my_pets/php/dbconnection.php');
                        
                        // Define the SQL query
                        $sql = "SELECT
                                  ah.historyID,
                                  u.userID AS adopter_id, 
                                  u.userName AS adopter_name, 
                                  u.email AS adopter_email, 
                                  u.contactInfo AS adopter_contact, 
                                  p.name AS pet_name,
                                  p.petID AS pet_id,
                                  p.photoPath AS pet_image,
                                  ah.adoption_date AS adoption_date
                                FROM adoption_history ah
                                JOIN users u ON ah.adopterID = u.userID
                                JOIN pets p ON ah.petID = p.petID";
                        
                        // Execute the query
                        $query = $conn->query($sql);
                        
                        // Check for errors in query execution
                        if (!$query) {
                            echo "Error executing query: " . $conn->error;
                        } else {
                            // Process result set
                            while($row = $query->fetch_assoc()) {
                                echo "<tr>
                                        <td>
                                          <a href='#edit_" . $row['adopter_id'] . "' class='btn btn-success btn-sm' data-toggle='modal'>Edit</a>
                                          <a href='deleteAdopter.php?historyID=" . $row['historyID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                                        </td>
                                        <td class='hidden-column'>" . $row['adopter_id'] . "</td>
                                        <td>" . $row['adopter_name'] . "</td>
                                        <td>" . $row['adopter_email'] . "</td>
                                        <td>" . $row['adopter_contact'] . "</td>
                                        <td>" . $row['pet_name'] . "</td>
                                        <td class='text-center'>
                                          <img src='/my_pets/pages/pet/function/upload/" . $row['pet_image'] . "' class='img-thumbnail' style='width:100px;' alt='Pet Image'>
                                        </td>
                                        <td>" . date('Y-m-d', strtotime($row['adoption_date'])) . "</td> <!-- Display adoption date -->
                                      </tr>";
                                // Include modal files (only for edit and delete)
                                include('edit_delete_modal.php');
                            }
                        }
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

<?php include '../includes/footer.php'; ?>
</body>
</html>