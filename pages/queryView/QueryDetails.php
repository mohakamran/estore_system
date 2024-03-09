<?php
session_start();
if (isset($_SESSION['userType'])) {


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';


  $QueryID = $_GET['QueryID'];

  include_once '../../assets/php/connection.php';

  $result = mysqli_query($con, "SELECT * FROM query WHERE id = '$QueryID'")
    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_array($result)) {
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Query Details</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Query</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Query Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="queryID">Query ID</label>
                          <input type="text" class="form-control" id="queryID" name="queryID" value="Q<?php echo $row["id"] ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="employeeID">Added By</label>
                          <input type="text" class="form-control" id="employeeID" name="employeeID" value="TW<?php echo $row["employeeID"] ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="queryDate">Query Date</label>
                          <input type="date" class="form-control" id="queryDate" name="queryDate" value="<?php echo $row["queryDate"] ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="queryStatus">Query Status</label>
                          <input type="text" class="form-control" id="queryStatus" name="queryStatus" value="<?php
                                                                                                              if ($row["queryStatus"] == 1) {
                                                                                                                echo "Pending";
                                                                                                              } else if ($row["queryStatus"] == 2) {
                                                                                                                echo "In-Progress";
                                                                                                              } else if ($row["queryStatus"] == 3) {
                                                                                                                echo "Resolved";
                                                                                                              }
                                                                                                              ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="customerName">Customer Name</label>
                          <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo $row["customerName"] ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <?php if ($_SESSION["userType"] == "0") { ?>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="customerContact">Customer Contact</label>
                            <input type="text" class="form-control" id="customerContact" name="customerContact" value="<?php echo $row["customerContact"] ?>" disabled>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="customerEmail">Customer Email</label>
                            <input type="text" class="form-control" id="customerEmail" name="customerEmail" value="<?php echo $row["customerEmail"] ?>" disabled>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="queryDescription">Description</label>
                          <textarea class="form-control" id="queryDescription" name="queryDescription" rows="3" disabled><?php echo $row["queryDescription"] ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
  <?php
    }
  }

  include '../elements/footer.php';
  ?>
  <script>
    $("#navQueryTree").addClass("menu-open");
    $("#navQuery").addClass("active");
    $("#navViewQuery").addClass("active");
  </script>
<?php

} else {
?>
  <script>
    window.open('../../', '_self')
  </script>
<?php
}


?>