<?php
session_start();
date_default_timezone_set('GMT');
if (isset($_SESSION['userType'])) {


  include '../elements/header.php';

?>
<!-- Select2 -->
<link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="../../vendor/plugins/daterangepicker/daterangepicker.css">
<?php

  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';
  include_once '../../assets/php/connection.php';
  include 'generateQuotation.php';
  include '../elements/footer.php';

  ?>
<!-- jquery-validation -->
<script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Select2 -->
<script src="../../vendor/plugins/select2/js/select2.full.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../vendor/plugins/moment/moment.min.js"></script>
<script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- InputMask -->
<script src="../../vendor/plugins/moment/moment.min.js"></script>
<script src="../../vendor/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../vendor/plugins/daterangepicker/daterangepicker.js"></script>

<!-- Page specific script -->
<script>
$("#navQuotationTree").addClass("menu-open");
$("#navQuotation").addClass("active");
$("#navQuotation").addClass("active");

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
})


$(document).ready(function() {

    $('#checkboxPrimary').change(function() {
        if ($("#customerEmail").val() == "") {
            swal("Error!", "Customer email should not be empty for sending mails", "error");
            $("#customerEmail").focus();
            $('#checkboxPrimary').prop('checked', false);
        }
    });


    $('#customerSelect').change(function() {
        if ($("#customerSelect").val() == "") {
            $("#customerName").attr('disabled', false);
            $("#customerMobile").attr('disabled', false);
            $("#customerEmail").attr('disabled', false);
        } else {
            $("#customerName").attr('disabled', true);
            $("#customerMobile").attr('disabled', true);
            $("#customerEmail").attr('disabled', true);
        }
    });

    $('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('wheel.disableScroll', function(e) {
            e.preventDefault()
        })
    })
    $('form').on('blur', 'input[type=number]', function(e) {
        $(this).off('wheel.disableScroll')
    })

    $(".select2bs4").on('change', function() {
        validator.resetForm();
        $(".loader").fadeIn();
        $.ajax({
            type: 'POST',
            url: "../../assets/php/getCustomerDetails.php",
            data: {
                customerID: $(this).val()
            },
            success: function(data) {
                $(".loader").fadeOut();
                var customerData = jQuery.parseJSON(data);
                $("#customerName").val(customerData[0].name);
                $("#customerMobile").val(customerData[0].phone);
                $("#customerEmail").val(customerData[0].email);
            }
        });
    })


    //INVOICE FORM VALIDATION
    var validator = $('#quotationGenerationForm').validate({
        submitHandler: function() {
            generateQuotation();
        },
        rules: {
            quotationDate: {
                required: true
            },
            customerName: {
                required: true
            },
            customerMobile: {
                required: true
            },
            customerEmail: {
                email: true
            },
            itemName: {
                required: true
            },
            quotationCostPrice: {
                required: true
            },
            quotationSellingPrice: {
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

    $("#quotationNumber").val('<?php echo time(); ?>');

});


function addItem() {
    var workCardDetail =
        '<div class="card card-primary itemDetailsCard"><div class="card-header"><h3 class="card-title">Service Details</h3><div class="card-tools"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
        "'" + '.card' + "'" +
        ').remove();"> <i class="fas fa-trash"></i> </button></div></div><div class="card-body"><div class="row"><div class="col-12"><div class="form-group"> <label for="itemName">Service Name</label> <input type="text" name="itemName" id="itemName" class="form-control itemName" placeholder="Enter item name"></div></div></div><div class="row"><div class="col-12"><div class="form-group"> <label for="itemName">Service Description</label><textarea name="itemDescription" id="itemDescription" class="form-control itemDescription" placeholder="Enter item description"></textarea></div><div class="row"> <div class="col-12"> <div class="form-group"> <label for="itemName">Service Duration(Hrs)</label> <input type="number" name="itemDuration" id="itemDuration" class="form-control itemDuration" placeholder="Enter item duration"/> </div></div></div></div></div></div></div>';
    $("#itemCardBody").append(workCardDetail);
}


function generateQuotation() {

    var employeeID = <?= $_SESSION['id'] ?>;
    var emailDocument = 0;

    if ($("#checkboxPrimary").is(':checked')) {
        emailDocument = 1;
    } else {
        emailDocument = 0;
    }

    var cards = document.getElementsByClassName('itemDetailsCard');
    var items = [];
    for (var i = 0; i < cards.length; i++) {
        var item = {
            itemName: cards[i].getElementsByClassName('itemName')[0].value ? cards[i].getElementsByClassName(
                'itemName')[0].value : "",
            itemDescription: cards[i].getElementsByClassName('itemDescription')[0].value ? cards[i]
                .getElementsByClassName('itemDescription')[0].value : "",
            itemDuration: cards[i].getElementsByClassName('itemDuration')[0].value ? cards[i]
                .getElementsByClassName('itemDuration')[0].value : 0,
        }
        items.push(item);
    }

    $.ajax({
        type: 'POST',
        url: "../../assets/php/addQuotation.php",
        data: {
            quotationNumber: $("#quotationNumber").val(),
            referenceNumber: "",
            quotationDate: moment($("#quotationDate").val()).format('YYYY-MM-DD'),
            company: $("#companySelect").val(),
            employeeID: employeeID,
            customerID: $("#customerSelect").val(),
            customerName: $("#customerName").val(),
            customerMobile: $("#customerMobile").val(),
            customerEmail: $("#customerEmail").val(),
            quotationItems: JSON.stringify(items),
            quotationCostPrice: $("#quotationCostPrice").val(),
            quotationSellingPrice: $("#quotationSellingPrice").val(),
            emailDocument: emailDocument
        },
        beforeSend: function() {
            $('.loader').fadeIn();
        },
        success: function(response) {
            console.log(response);
            if (response.trim() == "success") {
                $('.loader').fadeOut();
                swal("Success!", "Quotation Generated!", "success")
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