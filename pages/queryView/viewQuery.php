<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Query</h1>
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
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Query List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableQuery" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Added By</th>
                    <th>Customer Name</th>
                    <?php if ($_SESSION["userType"] == "0") { ?>
                      <th>Customer Contact</th>
                    <?php } ?>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result = mysqli_query($con, "SELECT * FROM query")
                    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr class="datatable-query-<?= $row["id"]; ?>">
                        <td><?php echo "Q" . $row["id"]; ?></td>
                        <td><?php echo "HW" . $row["employeeID"]; ?></td>
                        <td><?php echo $row["customerName"] ?></td>
                        <?php if ($_SESSION["userType"] == "0") { ?>
                          <td><?php echo $row["customerContact"]; ?></td>
                        <?php } ?>
                        <td><?php echo date("d-m-Y", strtotime($row["queryDate"])); ?></td>
                        <td>
                          <?php
                          if ($row["queryStatus"] == 1) {
                            echo "Pending";
                          } else if ($row["queryStatus"] == 2) {
                            echo "In-Progress";
                          } else if ($row["queryStatus"] == 3) {
                            echo "Resolved";
                          }
                          ?>
                        </td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewQuery(<?php echo htmlentities(json_encode($row["id"])); ?>);">VIEW</button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editQuery(<?php echo htmlentities(json_encode($row["id"])); ?>);">EDIT</button>
                          <?php
                          if ($_SESSION["userType"] == "0") {
                            ?>
                            <button type="button" name="button" class="btn btn-danger" onclick="deleteQuery(<?php echo htmlentities(json_encode($row["id"])); ?>);">DELETE</button>
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
