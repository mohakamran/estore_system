<?php
session_start();
if(isset($_SESSION['userType'])){

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';

  include('../../assets/php/connection.php');

  $empID = $_GET['empID'];
  $result= mysqli_query($con, " SELECT * FROM user WHERE id = '$empID'")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){
    while($row = mysqli_fetch_array($result)){
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Employee Edit</h1>
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
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Employee Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" id="employeeEditForm">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" value="<?=$row['fname'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" value="<?=$row['lname'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?=$row['email'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputPassword1">Contact number</label>
                            <input type="number" class="form-control" id="contact" name="contact" placeholder="Enter contact number" value="<?=$row['phone'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <!-- select -->
                          <div class="form-group">
                            <label>User Type</label>
                            <select id="employeeType" class="form-control">
                              <option value="1" <?php if($row['userType'] == '1') echo 'selected'; ?>>Employee</option>
                              <option value="0" <?php if($row['userType'] == '0') echo 'selected'; ?>>Admin</option>
                            </select>
                          </div>
                        </div>
                          <div class="col-md-6 col-sm-12">
                            <!-- select -->
                            <div class="form-group">
                              <label>Account Status</label>
                              <select id="employeeStatus" class="form-control">
                                <option value="1" <?php if($row['status'] == '1') echo 'selected'; ?>>Active</option>
                                <option value="0" <?php if($row['status'] == '0') echo 'selected'; ?>>Disabled</option>
                              </select>
                            </div>
                          </div>
                      </div>

                      <!-- textarea -->
                      <div class="form-group">
                        <label>Extra info.</label>
                        <textarea class="form-control" rows="3" id="address" name="address" placeholder=""><?=$row['address'] ?></textarea>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary float-right">Update</button>
                      <button type="button" class="btn btn-info float-right" onclick="window.open('index.php','_self');" style="margin-right: 10px;">Cancel</button>
                    </div>
                  </form>
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

  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript">
  //FORM VALIDATION ***************

  $("#navEmployeeTree").addClass("menu-open");
  $("#navEmployee").addClass("active");
  $("#navViewEmployee").addClass("active");


  $(document).ready(function () {

    //Employee Edit Form
    $('#employeeEditForm').validate({
      submitHandler: function () {
        updateEmployee();
      },
      rules: {
        fname: {
          required: true
        },
        lname: {
          required: true
        },
        contact: {
          required: true
        },
        email: {
          required: true,
          email: true,
        },
      },
      messages: {
        fname: {
          required: "Please enter first name"
        },
        lname: {
          required: "Please enter last name"
        },
        contact: {
          required: "Please enter conatact number"
        },
        email: {
          required: "Please enter email address",
          email: "Please enter a vaild email address"
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

  });


  function updateEmployee(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/employeeUpdate.php',
      data: {
        EmpID : <?=json_encode($empID) ?>,
        FName: $('#fname').val(),
        LName: $('#lname').val(),
        Contact: $('#contact').val(),
        Email: $('#email').val(),
        EmpType: $('#employeeType').val(),
        Address: $('#address').val(),
        Status: $('#employeeStatus').val()
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Employee details updated!", "success")
          .then((value) => {
            location.reload();
          });
        }else {
          $('.loader').fadeOut();
          swal("Error!", "An error occurred, please try again!", "error");
        }
      }
    });
  }

</script>

<?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
