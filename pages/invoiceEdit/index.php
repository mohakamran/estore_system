<?php
session_start();
date_default_timezone_set('GMT');
if (isset($_SESSION['userType'])) {


  include '../elements/header.php';

?>
<!-- Select2 -->
<link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css"
    rel="stylesheet" />
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<?php

  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';

  include_once '../../assets/php/connection.php';

  $employeeID = $_SESSION['id'];
  include 'editInvoice.php';

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
<script src="../../vendor/plugins/filer/js/jquery.filer.js"></script>

<!-- Page specific script -->
<script>
$("#navInvoiceTree").addClass("menu-open");
$("#navInvoice").addClass("active");
$("#navViewInvoice").addClass("active");

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
})

var products = 1;
var payments = 1;
var obj;
var productId;
var productCostPrice;
var productSellingPrice;
var productQuantity;
var paymentAmount = "";
var paymentType = "";
var paidDate = "";

var invoiceID = '<?=$invoiceID; ?>';
var attachments = ('<?=$attachments; ?>' ? JSON.parse('<?=$attachments; ?>') : JSON.parse('[]'));
var folderName = 'Invoice-' + invoiceID;

$(document).ready(function() {

    if ($('#recurring').val() == "0") {
        $("#endDateContainer").fadeOut();
    }

    $('#recurring').change(function() {
        if ($(this).val() == "1") {
            $("#endDateContainer").fadeIn();
        } else {
            $("#endDateContainer").fadeOut();
        }
    });

    $("#attachments-list").val(JSON.stringify(attachments));

    var fileDetails = [];
    var fileAttachmentNames = [];
    for (af in attachments) {
        var req = new XMLHttpRequest();
        req.open('HEAD', '../../assets/uploads/' + folderName + '/' + attachments[af], false);
        req.send();
        if (req.status == 200) {
            var fileDetail = {
                name: attachments[af],
                file: '../../assets/uploads/' + folderName + '/' + attachments[af],
                type: 'image/*',
                url: '../../assets/uploads/' + folderName + '/' + attachments[af]
            }
            fileAttachmentNames.push(attachments[af])
            fileDetails.push(fileDetail);
        }
    }
    addFiles('attachments', fileDetails, fileAttachmentNames);

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
    var validator = $('#invoiceGenerationForm').validate({
        submitHandler: function() {
            generateInvoice();
        },
        rules: {
            invoiceDate: {
                required: true
            },
            endDate: {
                required: true
            },
            paymentDue: {
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
            productSelect: {
                required: true
            },
            productCostPrice: {
                required: true
            },
            productSellingPrice: {
                required: true
            },
            productQuantity: {
                required: true
            },
            paymentAmount: {
                required: true
            },
            paidDate: {
                required: true
            }
        },
        messages: {
            customerName: {
                required: "Please enter full name"
            },
            customerMobile: {
                required: "Please enter conatact number"
            },
            customerAddress: {
                required: "Please enter address"
            },
            productCostPrice: {
                required: "Please enter service cost price"
            },
            productSellingPrice: {
                required: "Please enter service selling price"
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
    products = <?= sizeof($productIdArray); ?>;
    payments = <?= sizeof($paymentType); ?>;
    getProducts();
});

function getProducts() {
    $.ajax({
        type: 'POST',
        url: "../../assets/php/getProducts.php",
        success: function(data) {
            obj = jQuery.parseJSON(data);
            for (var i = 1; i <= products; i++) {
                addProductList(i);
            }
        }
    });
}

function addProductList(id) {
    if ($("#productSelect-" + id).val() == null) {
        $("#productSelect-" + id).append('<option value="" selected disabled>Select a service</option>');
    }
    for (var i = 0; i < obj.length; i++) {
        $("#productSelect-" + id).append('<option value="' + obj[i].id + '">' + obj[i].name + '</option>');
    }
}

function updateProductDescription(id) {
    var description;
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].id == $("#productSelect-" + id).val()) {
            description = obj[i].description;
        }
    }
    $("#productDescription-" + id).text(description);
}

function updateProductTotal(id) {

    var costPrice = $("#productCostPrice-" + id).val();
    var sellingPrice = $("#productSellingPrice-" + id).val();
    var quantity = $("#productQuantity-" + id).val();

    if (costPrice != "") {
        $("#product-" + id + "-cost").text(parseFloat(costPrice).toFixed(2));
    } else {
        $("#product-" + id + "-cost").text("0.00");
    }

    if (sellingPrice != "") {
        $("#product-" + id + "-total").text(parseFloat(sellingPrice).toFixed(2));
    } else {
        $("#product-" + id + "-total").text("0.00");
    }
    updateOrderTotal();
}

function updateOrderTotal() {
    var total = 0;
    for (var i = 1; i <= products; i++) {
        if ($("#product-" + i + "-total").text() != "") {
            total = (parseFloat(total) + parseFloat($("#product-" + i + "-total").text().replace(',', '')));
        }
    }
    $("#orderTotal").text(total.toFixed(2));
}

function updatePaymentTotal() {
    var total = 0;
    for (var i = 1; i <= payments; i++) {
        if ($("#paymentAmount-" + i).val() != "") {
            total = (parseFloat(total) + parseFloat($("#paymentAmount-" + i).val().replace(',', '')));
        }
    }
    $("#paymentTotal").text(total.toFixed(2));
}

function validateTotal() {
    var error = false;
    if (parseFloat($("#paymentTotal").text().replace(',', '')) >= parseFloat($("#orderTotal").text().replace(',',
            ''))) {
        error = true;
    }
    return error;
}


function checkProducts() {
    if (products == 1) {
        $(".removeProduct").prop("disabled", "true");
    } else {
        $(".removeProduct").removeAttr("disabled");
    }
}


function checkPayments() {
    if (payments == 0) {
        $(".removePayment").prop("hidden", "true");
    } else {
        $(".removePayment").removeAttr("hidden");
    }
}

function addProduct() {
    products++;
    $("#productList").append('<div class="row" id="product-' + products +
        '"> <div class="col-md-12"> <div class="card card-primary"> <div class="card-header"> <h3 class="card-title">Service - ' +
        products +
        '</h3> <div class="card-tools"> <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"> <i class="fas fa-minus"></i></button> </div></div><div class="card-body"> <div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="inputStatus">Service</label> <select class="form-control custom-select productSelect" id="productSelect-' +
        products + '" onchange="updateProductDescription(' + products +
        ');"> </select> </div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="productDescription">Service Description</label> <textarea name="productDescription" id="productDescription-' +
        products +
        '" class="form-control" disabled></textarea> </div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="inputName">Service price (£)</label> <input type="number" name="productPrice" id="productCostPrice-' +
        products +
        '" class="form-control" placeholder="Enter cost price per service" onkeyup="updateProductTotal(' +
        products +
        ');"> </div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="inputName">Selling price (£)</label> <input type="number" name="productQuantity" id="productSellingPrice-' +
        products +
        '" class="form-control" placeholder="Enter selling price per service" onkeyup="updateProductTotal(' +
        products +
        ');"> </div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="inputName">Quantity</label> <input type="number" name="productQuantity" id="productQuantity-' +
        products + '" class="form-control" placeholder="Enter service quantity" onkeyup="updateProductTotal(' +
        products +
        ');" value="1"> </div></div><div class="col-md-6 col-sm-12 text-right"> <span><b>Service Cost Price: </b><span></span>£ <span id="product-' +
        products +
        '-cost">0.00</span></span><br><br><span><b>Service Selling Price: </b><span></span>£ <span id="product-' +
        products + '-total">0.00</span></span> </div></div></div></div></div></div>');
    checkProducts();
    addProductList(products);
}

function addPayment() {
    payments++;
    $("#paymentList").append('<div class="row" id="payment-' + payments +
        '"> <div class="col-md-12"> <div class="card card-primary"> <div class="card-header"> <h3 class="card-title">Payment - ' +
        payments +
        '</h3> <div class="card-tools"> <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"> <i class="fas fa-minus"></i></button> </div></div><div class="card-body"> <div class="row"> <div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="inputStatus">Payment Mode</label> <select class="form-control custom-select paymentSelect" id="paymentSelect-' +
        payments +
        '"> <option value="1">Bank Payment</option> <option value="2">Cash Payment</option> <option value="3">Other</option> </select> </div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="paymentAmount">Payment Amount (£)</label> <input type="number" name="paymentAmount" id="paymentAmount-' +
        payments +
        '" class="form-control paymentAmount" placeholder="Enter payment amount" onkeyup="updatePaymentTotal();"> </div></div><div class="col-md-4 col-sm-12"><div class="form-group"><div class="form-group"><label>Payment Date</label><input type="date" name="paidDate" id="paidDate-' +
        payments + '" class="form-control paidDate"></div></div></div></div></div></div></div></div>');
    if (parseFloat($("#paymentTotal").text().replace(',', '')) < parseFloat($("#orderTotal").text().replace(',', ''))) {
        $("#paymentAmount-" + payments).val(parseFloat($("#orderTotal").text().replace(',', '')) - parseFloat($(
            "#paymentTotal").text().replace(',', '')));
        $("#paymentTotal").text(parseFloat($("#orderTotal").text().replace(',', '')).toFixed(2));
    }
    checkPayments();
}

function removeProduct() {
    $("#product-" + products).remove();
    products--;
    checkProducts();
    updateOrderTotal();
}

function removePayment() {
    if (payments > 0) {
        $("#payment-" + payments).remove();
        payments--;
        checkPayments();
        updatePaymentTotal();
    }
}


function generateInvoice() {
    productId = "";
    productQuantity = "";
    productSellingPrice = "";
    productCostPrice = "";
    paymentAmount = "";
    paymentType = "";
    paidDate = "";
    for (var i = 1; i <= products; i++) {
        productId = productId + $("#productSelect-" + i).val() + ",";
        productCostPrice = productCostPrice + $("#productCostPrice-" + i).val() + ",";
        productSellingPrice = productSellingPrice + $("#productSellingPrice-" + i).val() + ",";
        productQuantity = productQuantity + $("#productQuantity-" + i).val() + ",";
    }
    for (var i = 1; i <= payments; i++) {
        paymentAmount = paymentAmount + $("#paymentAmount-" + i).val() + ",";
        paymentType = paymentType + $("#paymentSelect-" + i).val() + ",";
        paidDate = paidDate + moment($("#paidDate-" + i).val()).format('YYYY-MM-DD') + ",";
    }
    saveInvoice();
}

function saveInvoice() {

    var invoiceStatus = 0;
    var employeeID = <?= $_SESSION['id'] ?>;
    var emailDocument = 0;

    if (validateTotal()) {
        invoiceStatus = 1;
    }

    if ($("#checkboxPrimary").is(':checked')) {
        emailDocument = 1;
    } else {
        emailDocument = 0;
    }
    var customerMobile = $('#customerMobile').val() == undefined ? "" : $('#customerMobile').val();
    var customerEmail = $('#customerEmail').val() == undefined ? "" : $('#customerEmail').val();
    $.ajax({
        type: 'POST',
        url: "../../assets/php/updateInvoice.php",
        data: {
            invoiceID: $("#invoiceNumber").val(),
            referenceNumber: "",
            recurring: $("#recurring").val(),
            endDate: moment($("#invoiceDateInput").val()).format('YYYY-MM-DD'),
            invoiceDate: moment($("#invoiceDateInput").val()).format('YYYY-MM-DD'),
            paymentDate: moment($("#paymentDateInput").val()).format('YYYY-MM-DD'),
            company: $("#companySelect").val(),
            employeeID: employeeID,
            customerID: $("#customerSelect").val(),
            customerName: $("#customerName").val(),
            customerMobile: customerMobile,
            customerEmail: customerEmail,
            productID: productId,
            productCostPrice: productCostPrice,
            productSellingPrice: productSellingPrice,
            productQuantity: productQuantity,
            orderTotal: $("#orderTotal").text().replace(',', ''),
            paymentTotal: $("#paymentTotal").text().replace(',', ''),
            paymentAmount: paymentAmount,
            paymentType: paymentType,
            paidDate: paidDate,
            status: invoiceStatus,
            emailDocument: emailDocument,
            attachments: JSON.stringify(JSON.parse($('#attachments-list').val())),
            notes: $("#notes").val(),
        },
        beforeSend: function() {
            $('.loader').fadeIn();
        },
        success: function(response) {
            console.log(response);
            $('.loader').fadeOut();
            if (response.trim() == "success") {
                $('.loader').fadeOut();
                swal("Success!", "Invoice Updated!", "success")
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




function addFiles(filerID, fileDetails, fileAttachmentNames) {
    var uploadedFiles = fileAttachmentNames;
    $("#" + filerID).filer({
        limit: null,
        maxSize: null,
        extensions: ["jpg", "png", "gif"],
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: true,
        theme: "dragdropbox",
        files: fileDetails,
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
            <div class="jFiler-item-container">\
            <div class="jFiler-item-inner">\
            <div class="jFiler-item-thumb">\
            <div class="jFiler-item-status"></div>\
            <div class="jFiler-item-thumb-overlay">\
            <div class="jFiler-item-info">\
            <div style="display:table-cell;vertical-align: middle;">\
            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
            <span class="jFiler-item-others">{{fi-size2}}</span>\
            </div>\
            </div>\
            </div>\
            {{fi-image}}\
            </div>\
            <div class="jFiler-item-assets jFiler-row">\
            <ul class="list-inline pull-left">\
            <li>{{fi-progressBar}}</li>\
            </ul>\
            <ul class="list-inline pull-right">\
            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
            </ul>\
            </div>\
            </div>\
            </div>\
            </li>',
            itemAppend: '<li class="jFiler-item">\
            <div class="jFiler-item-container">\
            <div class="jFiler-item-inner">\
            <div class="jFiler-item-thumb">\
            <div class="jFiler-item-status"></div>\
            <div class="jFiler-item-thumb-overlay">\
            <div class="jFiler-item-info">\
            <div style="display:table-cell;vertical-align: middle;">\
            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
            <span class="jFiler-item-others">{{fi-size2}}</span>\
            </div>\
            </div>\
            </div>\
            {{fi-image}}\
            </div>\
            <div class="jFiler-item-assets jFiler-row">\
            <ul class="list-inline pull-left">\
            <li><span class="downloadButton" id="{{fi-name}}" onclick="downloadAttachment(this)" style="color: #4285F4;"><i class="fas fa-2x fa-arrow-circle-down"></i></span></li>\
            </ul>\
            <ul class="list-inline pull-right">\
            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
            </ul>\
            </div>\
            </div>\
            </div>\
            </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            canvasImage: true,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
            dragContainer: null,
        },
        uploadFile: {
            url: "../../vendor/plugins/filer/php/ajax_upload_file.php",
            data: {
                folderName: folderName,
            },
            type: 'POST',
            enctype: 'multipart/form-data',
            synchron: true,
            beforeSend: function() {},
            success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
                var parent = itemEl.find(".jFiler-jProgressBar").parent(),
                    new_file_name = JSON.parse(data),
                    filerKit = inputEl.prop("jFiler");
                filerKit.files_list[id].name = new_file_name;
                uploadedFiles.push(new_file_name);
                $("#" + filerID + "-list").val(JSON.stringify(uploadedFiles))
                itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                    $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>")
                        .hide().appendTo(parent).fadeIn("slow");
                });
            },
            error: function(el) {
                var parent = el.find(".jFiler-jProgressBar").parent();
                el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                    $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>")
                        .hide().appendTo(parent).fadeIn("slow");
                });
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        },
        allowDuplicates: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var filerKit = inputEl.prop("jFiler"),
                file_name = filerKit.files_list[id].name;
            if (file_name == undefined) {
                file_name = filerKit.files_list[id].file.name;
            }
            uploadedFiles = jQuery.grep(uploadedFiles, function(value) {
                return value != file_name;
            });
            $("#" + filerID + "-list").val(JSON.stringify(uploadedFiles))
            $.post('../../vendor/plugins/filer/php/ajax_remove_file.php?folderName=' + folderName, {
                file: file_name
            });
        },
        onEmpty: null,
        options: null,
        dialogs: {
            alert: function(text) {
                return alert(text);
            },
            confirm: function(text, callback) {
                confirm(text) ? callback() : null;
            }
        },
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });
}

function downloadAttachment(fileName) {
    window.open('../../assets/uploads/' + folderName + '/' + fileName.id, '_self');
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