<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Quotation</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Quotation</li>
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
              <h3 class="card-title">Quotation List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableQuotation" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Quotation ID</th>
                    <th>Added By</th>
                    <th>Quotation Date</th>
                    <th>Amount</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $empID = $_SESSION['id'];

                  $result = mysqli_query($con, "SELECT * FROM quotation")
                    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr class="datatable-quotation-<?= $row["id"]; ?>">
                        <td><?php echo $row["quotationID"]; ?></td>
                        <td>
                          <?php
                          $addedName = "";
                          $addedId = $row["employeeID"];
                          $resultEmp = mysqli_query($con, "SELECT fname FROM user WHERE id = '$addedId'")
                            or die('An error occurred! Unable to process this request. ' . mysqli_error($con));
                          if (mysqli_num_rows($resultEmp) > 0) {
                            while ($rowEmp = mysqli_fetch_array($resultEmp)) {
                              $addedName = $rowEmp['fname'];
                            }
                          }
                          echo $addedName;
                          ?>
                        </td>
                        <td><?php echo date('d-m-Y', strtotime($row["quotationDate"])); ?></td>
                        <td>£ <?php echo number_format($row["sellingPrice"], 2); ?></td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewQuotation(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editQuotation(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-edit"></i></button>
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
