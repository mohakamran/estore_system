<?php
session_start();
if (isset($_SESSION['userType'])) {


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';


  $reminderID = $_GET['reminderID'];

  include_once '../../assets/php/connection.php';

  $result = mysqli_query($con, "SELECT * FROM reminder WHERE id = '$reminderID'")
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
                <h1>Reminder Details</h1>
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
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Reminder Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label for="reminderDate">Reminder Date</label>
                          <input type="date" class="form-control" id="reminderDate" name="reminderDate" value="<?= $row['reminderDate'] ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label>Reminder Time</label>
                          <div class="input-group date" id="timepicker" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#timepicker" name="reminderTime" id="reminderTime" value="<?= $row['reminderTime'] ?>" disabled />
                            <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="customerName">Customer Name</label>
                          <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter customer name" value="<?= $row['customerName'] ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <?php
                    if ($_SESSION["userType"] == "0") {
                    ?>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="customerContact">Customer Contact</label>
                            <input type="number" class="form-control" id="customerContact" name="customerContact" placeholder="Enter customer contact number" value="<?= $row['customerContact'] ?>" disabled>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label for="customerEmail">Customer Email</label>
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Enter customer email" value="<?= $row['customerEmail'] ?>" disabled>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="reminderDescription">Description</label>
                          <textarea class="form-control" id="reminderDescription" name="reminderDescription" placeholder="Enter description/ notes." rows="3" disabled><?= $row['reminderDescription'] ?></textarea>
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
  <!-- InputMask -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script>
    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    $("#navReminderTree").addClass("menu-open");
    $("#navReminder").addClass("active");
    $("#navViewReminder").addClass("active");
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