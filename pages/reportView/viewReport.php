<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Report</li>
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
              <h3 class="card-title">Report List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableReport" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Report Type</th>
                    <th>Client Name</th>
                    <th>Project Name</th>
                    <th>Project Date</th>
                    <th>Product Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result = mysqli_query($con, "SELECT * FROM reports")
                  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {

                      ?>
                      <tr class="datatable-report-<?= $row["id"]; ?>">
                        <td>
                          <?= $row['reportType'] ?>
                        </td>
                        <td>
                          <?= $row['clientName'] ?>
                        </td>
                        <td>
                          <?= $row['projectName'] ?>
                        </td>
                        <td>
                          <?= date("d-m-Y", strtotime($row['projectStartDate'])) ?>
                        </td>
                        <td>
                          <?= $row['productName'] ?>
                        </td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewReport(<?= $row['id']; ?>);"><i class="fas fa-eye"></i></button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editReport(<?= $row['id']; ?>);"><i class="fas fa-edit"></i></button>
                          <?php
                          if ($_SESSION["userType"] == "0") {
                            ?>
                            <button type="button" name="button" class="btn btn-danger" onclick="deleteReport(<?= $row['id']; ?>);"><i class="fas fa-trash"></i></button>
                            <?php
                          }
                          ?>
                        </td>
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
