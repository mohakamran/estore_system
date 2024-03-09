<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'addProduct-v'.$_SESSION['userType'].'.php';
  include '../elements/footer.php';

  ?>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript">
  //FORM VALIDATION ***************

  $(document).ready(function () {

    $("#navProductTree").addClass("menu-open");
    $("#navProduct").addClass("active");
    $("#navAddProducts").addClass("active");

    //Product ADD Form
    $('#productAddForm').validate({
      submitHandler: function () {
        addProduct();
      },
      rules: {
        pName: {
          required: true
        },
        pDescription: {
          required: true
        },
      },
      messages: {
        pName: {
          required: "Please enter product name"
        },
        pDescription: {
          required: "Please enter product description"
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


  function addProduct(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/addProduct.php',
      data: {
        pName: $('#pName').val(),
        pDescription: $('#pDescription').val()
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Service added to database", "success")
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
