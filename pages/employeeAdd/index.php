<?php
session_start();
if(isset($_SESSION['userType'])){

  ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <?php
  $empID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include_once '../../assets/php/connection.php';
  include 'addEmployee-v'.$_SESSION['userType'].'.php';
  include '../elements/footer.php';

  ?>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript">


  $(document).ready(function () {

    $("#navEmployeeTree").addClass("menu-open");
    $("#navEmployee").addClass("active");
    $("#navAddEmployee").addClass("active");

    //Registration Form Admin
    $('#employeeRegistrationForm').validate({
      submitHandler: function () {
        employeeRegistrationAdmin();
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


    //Registration Form Group Admin
    $('#employeeRegistrationFormGAdmin').validate({
      submitHandler: function () {
        employeeRegistrationGroupAdmin();
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
        address: {
          required: true
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
        address: {
          required: "Please enter address"
        }
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
  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
