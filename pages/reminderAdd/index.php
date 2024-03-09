<?php
session_start();
if(isset($_SESSION['userType'])){

  ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <?php
  $empID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include_once '../../assets/php/connection.php';
  include 'addReminder.php';
  include '../elements/footer.php';

  ?>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- InputMask -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script type="text/javascript">


  $(document).ready(function () {

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    $("#navReminderTree").addClass("menu-open");
    $("#navReminder").addClass("active");
    $("#navAddReminder").addClass("active");

    //Addition Form - Reminder
    $('#reminderForm').validate({
      submitHandler: function () {
        reminderAddition();
      },
      rules: {
        reminderDate: {
          required: true
        },
        reminderTime: {
          required: true
        },
        reminderDescription: {
          required: true
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

  function reminderAddition(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/reminderAddition.php',
      data: {
        reminderDate: moment($('#reminderDate').val()).format('YYYY-MM-DD'),
        reminderTime: moment($("#reminderTime").val(), ["h:mm A"]).format("HH:mm:ss"),
        customerName: $('#customerName').val(),
        customerContact: $('#customerContact').val(),
        customerEmail: $('#customerEmail').val(),
        reminderDescription: $('#reminderDescription').val(),
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Reminder Added!", "success")
          .then((value) => {
            location.reload();
          });
        }else{
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
