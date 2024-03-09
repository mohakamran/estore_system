<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <?php

          include('../../assets/php/connection.php');

          $result= mysqli_query($con, " SELECT * FROM user WHERE id = '$empID'")
          or die('An error occurred! Unable to process this request. '. mysqli_error($con));

          if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_array($result)){
              $empType = $row['userType'];
              $empName = $row['fname']." ".$row['lname'];
              ?>

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                    src="
                    <?php if($row['profilePicture'] == null){
                      echo '../../assets/images/avatar0.png';
                    }else{
                      echo '../../assets/profiles/'.$row['profilePicture'].'?'.time();
                    } ?>
                    "
                    alt="User profile picture">
                    <input  type="file" accept="image/*" id="upload" value="Choose a file" hidden>
                    <input type="hidden" id="imagebase64" name="imagebase64" hidden>
                  </div>


                  <div class="modal fade" id="modal-sm">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Profile picture</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <button type="button" class="btn btn-danger" id="removePicture">Remove picture</button>
                          <button type="button" class="btn btn-primary" id="changePicture">Change picture</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->



                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-sm" id="smallModal" hidden>
                    Launch Small Modal
                  </button>


                  <!-- This is the modal -->
                  <div class="modal" tabindex="-1" role="dialog" id="uploadimageModal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Upload image</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12 text-center">
                              <div id="image_demo"></div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary crop_image">Crop and Save</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>


                  <h3 class="profile-username text-center"><?=$row['fname']." ".$row['lname'] ?></h3>

                  <p class="text-muted text-center"><?php echo "HW".$row["id"]; ?></p>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>
                  <p class="text-muted"><?=$row['phone'] ?></p>
                  <hr>

                  <strong><i class="fas fa-at mr-1"></i> Email</strong>
                  <p class="text-muted"><?=$row['email'] ?></p>
                  <hr>

                  <strong><i class="fas fa-calendar mr-1"></i> Joining Date</strong>
                  <p class="text-muted"><?=$row['joiningDate'] ?></p>
                  <hr>

                  <strong><i class="fas fa-info-circle mr-1"></i> Extra info.</strong>
                  <p class="text-muted"><?=$row['address'] ?></p>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <?php

            }
          }

          ?>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <?php if($empType != '0'){
                  ?>
                  <li class="nav-item"><a class="nav-link active" href="#attendance" data-toggle="tab">Attendance</a></li>
                  <?php
                }
                ?>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                  <div class="active tab-pane" id="attendance">

                    <!-- THE CALENDAR -->
                    <div id="calendar"></div><br>
                    <div class="form-group">
                      <label for="attendanceCount">Attendance Count (days)</label>
                      <input type="text" id="attendanceCount" name="attendanceCount" class="form-control" value="0" disabled>
                    </div>
                    <div class="form-group">
                      <label for="totalHours">Total Time (hrs)</label>
                      <input type="text" id="totalHours" name="totalHours" class="form-control" value="0" disabled>
                    </div>

                    <div class="modal fade" id="modal-overlay">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form role="form" id="attendanceUpdateForm">
                            <div class="overlayContent">

                            </div>

                            <div class="modal-header">
                              <h4 class="modal-title" id="attendanceTitle"></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" id="attendanceModal">
                            </div>
                            <div class="modal-footer justify-content-between">
                              <input type="text" id="attendanceExists" value="-1" hidden>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-overlay" id="modalButton" hidden>
                      Launch Modal with Overlay
                    </button>

                  </div>

              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
