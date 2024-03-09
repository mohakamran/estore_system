<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View Certificates</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Certificates</li>
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
              <h3 class="card-title">Certificates List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tableCert" class="table table-bordered">
                <thead>
                  <tr>
                    <th>PropertyID</th>
                    <th>Address</th>
                    <th>Certificate Type</th>
                    <th>Valid From</th>
                    <th>Expiring On</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  include_once '../../assets/php/connection.php';

                  $result= mysqli_query($con, "SELECT id, propertyAddress, propertyCertificates FROM property")
                  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                  if(mysqli_num_rows($result) > 0 ){
                    // output data of each row
                    while($row = mysqli_fetch_array($result)) {

                      $certificates = json_decode($row["propertyCertificates"]);
                      for($index = 0; $index < sizeOf($certificates); $index++){
                        if(date("Y-m-d") > $certificates[$index]->expiryDate){
                          ?>
                          <tr class="datatable-property-<?=$row["id"]; ?> expired">
                            <?php
                          }else if(date("Y-m-d", strtotime('+14 day')) > $certificates[$index]->expiryDate){
                            ?>
                            <tr class="datatable-property-<?=$row["id"]; ?> expiring">
                              <?php
                            }else{
                              ?>
                              <tr class="datatable-property-<?=$row["id"]; ?>">
                                <?php
                              }
                            ?>
                            <td><?php echo "P-".$row["id"]; ?></td>
                            <td><?php echo $row["propertyAddress"]; ?></td>
                            <td><?php echo $certificates[$index]->certificateType; ?></td>
                            <td>
                              <?php
                              $date=date_create($certificates[$index]->validDate);
                              echo date_format($date,"d-m-Y");
                              ?>
                            </td>
                            <td>
                              <?php
                              $date=date_create($certificates[$index]->expiryDate);
                              echo date_format($date,"d-m-Y");
                              ?>
                            </td>
                            <td>
                              <button type="button" name="button" class="btn btn-info" onclick="viewProperty(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                            </td>
                          </tr>
                          <?php
                        }
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
