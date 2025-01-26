<?php
// Include database connection
include("dbconnection.php");

// Query to get the total number of available pets for adoption
$query1 = "SELECT COUNT(*) AS total_available_pets FROM pets WHERE status = 'Available'";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);
$total_available_pets = $row1['total_available_pets'];

// Query to get the total number of adopted pets
$query2 = "SELECT COUNT(*) AS total_adopted_pets FROM pets WHERE status = 'Adopted'";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_assoc($result2);
$total_adopted_pets = $row2['total_adopted_pets'];

// Query to get the total number of adoption requests
$query3 = "SELECT COUNT(*) AS total_adoption_requests FROM adoption_request";
$result3 = mysqli_query($conn, $query3);
$row3 = mysqli_fetch_assoc($result3);
$total_adoption_requests = $row3['total_adoption_requests'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../includes/header.php' ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../includes/navbar.php' ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include '../includes/sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Number of Adoption Requests -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $total_adoption_requests; ?></h3>
                <p>Number of Adoption Requests</p>
              </div>
              <div class="icon">
                <i class="ion ion-paw"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <!-- Number of Adopted Pets -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_adopted_pets; ?></h3>
                <p>Number of Adopted Pets</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark-circled"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <!-- Number of Available Pets -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_available_pets; ?></h3>
                <p>Number of Available Pets</p>
              </div>
              <div class="icon">
                <i class="ion ion-leaf"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php' ?>
</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php' ?>
</body>
</html>