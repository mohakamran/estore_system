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
  include 'addCustomer-v' . $_SESSION['userType'] . '.php';
  include '../elements/footer.php';

  ?>
<!-- jquery-validation -->
<script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    $("#navCustomerTree").addClass("menu-open");
    $("#navCustomer").addClass("active");
    $("#navAddCustomer").addClass("active");

    //Registration Form - Customer
    $('#customerRegistrationForm').validate({
        submitHandler: function() {
            customerRegistration();
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

function customerRegistration() {

    $.ajax({
        type: 'POST',
        url: '../../assets/php/customerRegistration.php',
        data: {
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
                swal("Success!", "Customer has been registered!", "success")
                    .then((value) => {
                        location.reload();
                    });
            } else if (response.trim() == "email") {
                $('#email').focus();
                $('.loader').fadeOut();
                swal("Error!", "Email ID already registered!", "error");
            } else if (response.trim() == "phone") {
                $('.loader').fadeOut();
                $('#contact').focus();
                swal("Error!", "Phone number already registered!", "error");
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