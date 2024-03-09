<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Services</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Service</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Services List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableProduct" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Service Name</th>
                    <th>Service Description</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $empID = $_SESSION['id'];

                  $result = mysqli_query($con, "SELECT * FROM product WHERE productStatus = '1'")
                  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                      ?>
                      <tr class="datatable-product-<?= $row["id"]; ?>">
                        <td><?php echo $row["productName"]; ?></td>
                        <td><?php echo $row["productDescription"]; ?></td>
                      </tr>
                      <?php
                    }
                  }

                  ?>
                </tbody>
              </table>
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
