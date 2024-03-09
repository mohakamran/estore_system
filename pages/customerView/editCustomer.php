<?php
session_start();
if (isset($_SESSION['userType'])) {

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';

  include('../../assets/php/connection.php');

  $customerID = $_GET['customerID'];
  $result = mysqli_query($con, " SELECT * FROM customer WHERE id = '$customerID'")
    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Customer Edit</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Customer</li>
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
                    <h3 class="card-title">Customer Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" id="customerEditForm">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?= $row['name'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="projectName">Project Name</label>
                            <input type="text" class="form-control" id="projectName" name="projectName" placeholder="Project name" value="<?= $row['project_name'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Customer Type</label>
                            <select id="customerType" class="form-control">
                              <option value="1" <?php if ($row['customer_type'] == 1) {
                                                  echo "selected";
                                                } ?>>One-Time Project</option>
                              <option value="0" <?php if ($row['customer_type'] == 0) {
                                                  echo "selected";
                                                } ?>>On-Going Project</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="startDate">Project Start Date</label>
                            <input type="date" class="form-control startDate" name="startDate" id="startDate" placeholder="Enter Project Start Date" value="<?= $row['project_start_date'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $row['email'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="number" class="form-control" id="contact" name="contact" placeholder="Enter Contact Details" value="<?= $row['contact'] ?>">
                          </div>
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

    $("#navCustomerTree").addClass("menu-open");
    $("#navCustomer").addClass("active");
    $("#navViewCustomer").addClass("active");


    $(document).ready(function() {

      //Customer Edit Form
      $('#customerEditForm').validate({
        submitHandler: function() {
          updateCustomer();
        },
        rules: {
          name: {
            required: true
          },
          email: {
            required: true
          },
          startDate: {
            required: true
          },
          projectName: {
            required: true
          },
          contact: {
            required: true
          },
          customerType: {
            required: true
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });

    });


    function updateCustomer() {

      $.ajax({
        type: 'POST',
        url: '../../assets/php/customerUpdate.php',
        data: {
          customerID: <?= json_encode($customerID) ?>,
          Name: $('#name').val(),
          ProjectName: $('#projectName').val(),
          Email: $('#email').val(),
          StartDate: $('#startDate').val(),
          CustomerType: $('#customerType').val(),
          Contact: $('#contact').val()
        },
        beforeSend: function() {
          $('.loader').fadeIn();
        },
        success: function(response) {
          console.log(response);
          if (response.trim() == "success") {
            $('.loader').fadeOut();
            swal("Success!", "Customer details updated!", "success")
              .then((value) => {
                location.reload();
              });
          } else {
            $('.loader').fadeOut();
            swal("Error!", "An error occurred, please try again!", "error");
          }
        }
      });
    }
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