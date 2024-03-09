<?php
session_start();
if (isset($_SESSION['userType'])) {

?>
  <!-- Select2 -->
  <link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <?php
  $empID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';
  include_once '../../assets/php/connection.php';
  include 'addQuery.php';
  include '../elements/footer.php';

  ?>
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      $("#navQueryTree").addClass("menu-open");
      $("#navQuery").addClass("active");
      $("#navAddQuery").addClass("active");

      $('#QueryForm').validate({
        submitHandler: function() {
          QueryAddition();
        },
        rules: {
          customerName: {
            required: true
          },
          customerContact: {
            required: true
          },
          queryDate: {
            required: true
          },
          queryStatus: {
            required: true
          },
          queryDescription: {
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

    function QueryAddition() {

      $.ajax({
        type: 'POST',
        url: '../../assets/php/queryAdd.php',
        data: {
          employeeID: <?= $_SESSION['id'] ?>,
          customerName: $('#customerName').val(),
          customerContact: $('#customerContact').val(),
          customerEmail: $('#customerEmail').val(),
          queryDate: moment($('#queryDate').val()).format('YYYY-MM-DD'),
          queryStatus: $('#queryStatus').val(),
          queryDescription: $('#queryDescription').val(),
        },
        beforeSend: function() {
          $('.loader').fadeIn();
        },
        success: function(response) {
          console.log(response);
          if (response.trim() == "success") {
            $('.loader').fadeOut();
            swal("Success!", "Query Added!", "success")
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