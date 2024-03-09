<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Reminder</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Reminder</li>
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
              <h3 class="card-title">Your Reminders</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped tableReminder">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Customer Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result = mysqli_query($con, "SELECT * FROM reminder WHERE employeeID = '$employeeID'")
                    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr class="datatable-reminder-<?= $row["id"]; ?>">
                        <td><?php echo date("d-m-Y", strtotime($row["reminderDate"])); ?></td>
                        <td><?php echo $row["reminderTime"] ?></td>
                        <td><?php echo $row["customerName"]; ?></td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-edit"></i></button>
                          <button type="button" name="button" class="btn btn-danger" onclick="deleteReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-trash"></i></button>
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
      </div><br>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Employee Reminders</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped tableReminder">
                <thead>
                  <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Customer Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result = mysqli_query($con, "SELECT * FROM reminder WHERE employeeID != '$employeeID'")
                    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr class="datatable-reminder-<?= $row["id"]; ?>">
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
                        <td><?php echo date('d-m-Y', strtotime($row["reminderDate"])); ?></td>
                        <td><?php echo $row["reminderTime"] ?></td>
                        <td><?php echo $row["customerName"]; ?></td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-edit"></i></button>
                          <button type="button" name="button" class="btn btn-danger" onclick="deleteReminder(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-trash"></i></button>
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