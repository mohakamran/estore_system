<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Employees</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Employee</li>
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
              <h3 class="card-title">Employee List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableEmployees" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Status</th>
                    <th>User Type</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result= mysqli_query($con, "SELECT * FROM user")
                  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                  if(mysqli_num_rows($result) > 0 ){
                    // output data of each row
                    while($row = mysqli_fetch_array($result)) {
                      ?>
                      <tr class="datatable-user-<?=$row["id"]; ?>">
                        <td><?php if($row["status"] == '0'){echo "Disabled";}else{echo "Active";} ?></td>
                        <td><?php if($row["userType"] == '0'){echo "Administrator";}else{echo "Employee";} ?></td>
                        <td><?php echo "HW".$row["id"]; ?></td>
                        <td><?php echo $row["fname"]." ".$row["lname"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td>
                          <button type="button" name="button" class="btn btn-info" onclick="viewProfile(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                          <button type="button" name="button" class="btn btn-primary" onclick="editProfile(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-edit"></i></button>
                          <button type="button" name="button" class="btn btn-danger" onclick="deleteProfile(<?=$row["userType"]; ?>, <?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-trash"></i></button>
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
