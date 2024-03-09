<?php
session_start();
if (isset($_SESSION['userType'])) {

?>
<!-- Select2 -->
<link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css"
    rel="stylesheet" />

<?php
    $empID = $_SESSION['id'];

    include '../elements/header.php';
    include '../elements/navbar.php';
    include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';
    include_once '../../assets/php/connection.php';
    include 'addReport.php';
    include '../elements/footer.php';
    ?>
<script src="../../vendor/plugins/moment/moment.min.js"></script>
<script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
<!-- jquery-validation -->
<script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../vendor/plugins/moment/moment.min.js"></script>
<script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script type="text/javascript">
var propertyTimestamp = '<?php echo time(); ?>';
var folderName = 'Property-' + propertyTimestamp;

$(document).ready(function() {

    $("#navReportTree").addClass("menu-open");
    $("#navReport").addClass("active");
    $("#navAddReport").addClass("active");

    var $radios = $('input[name=reportType]').change(function() {
        var value = $radios.filter(':checked').val();
        if (value == 'TASK') {
            $("#taskData").prop("hidden", false);
            $("#statsData").prop("hidden", true);
        } else if (value == 'STATS') {
            $("#taskData").attr("hidden", true);
            $("#statsData").attr("hidden", false);
        }
    });

    var $projects = $('input[name=projectType]').change(function() {
        var value = $projects.filter(':checked').val();
        if (value == 'New') {
            $(".projectNew").prop("hidden", false);
            $(".projectExist").prop("hidden", true);
        } else if (value == 'Existing') {
            $(".projectNew").attr("hidden", true);
            $(".projectExist").attr("hidden", false);
        }
    });

    $('#reportForm').validate({
        submitHandler: function() {
            reportAddition();
        },
        rules: {
            selectProject: {
                required: true
            },
            projectType: {
                required: true
            },
            clientName: {
                required: true
            },
            projectName: {
                required: true
            },
            statsDatePeriod: {
                required: true
            },
            projectStartDate: {
                required: true
            },
            resourceName: {
                required: true
            },
            productName: {
                required: true
            },
            asinSku: {
                required: true
            },
            impressions: {
                required: true
            },
            clicks: {
                required: true
            },
            spend: {
                required: true
            },
            roas: {
                required: true
            },
            organicOrders: {
                required: true
            },
            organicOrders: {
                required: true
            },
            sponsoredOrders: {
                required: true
            },
            sponsoredOrders: {
                required: true
            },
            overAllOrders: {
                required: true
            },
            overAllOrders: {
                required: true
            },
            organicOrders: {
                required: true
            },
            organicSales: {
                required: true
            },
            sponsoredOrders: {
                required: true
            },
            sponsoredSales: {
                required: true
            },
            overAllOrders: {
                required: true
            },
            overAllSales: {
                required: true
            },
            task: {
                required: true
            },
            reportType: {
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

function reportAddition() {
    // if()
    var cards = document.getElementsByClassName('reportDetailCard');
    var reports = [];
    var reportType = $("input:radio[name=reportType]:checked").val();
    for (var i = 0; i < cards.length; i++) {
        if (reportType == "STATS") {
            var spend = cards[i].getElementsByClassName('spend')[0].value ? cards[i].getElementsByClassName('spend')[0]
                .value : 0;
            var clicks = cards[i].getElementsByClassName('clicks')[0].value ? cards[i].getElementsByClassName('clicks')[
                0].value : 0;
            var report = {
                asinSku: cards[i].getElementsByClassName('asinSku')[0].value ? cards[i].getElementsByClassName(
                    'asinSku')[0].value : "",
                impressions: cards[i].getElementsByClassName('impressions')[0].value ? cards[i]
                    .getElementsByClassName('impressions')[0].value : 0,
                clicks: clicks,
                spend: spend,
                cpc: spend / clicks,
                organicOrders: cards[i].getElementsByClassName('organicOrders')[0].value ? cards[i]
                    .getElementsByClassName('organicOrders')[0].value : 0,
                sponsoredOrders: cards[i].getElementsByClassName('sponsoredOrders')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredOrders')[0].value : 0,
                organicSales: cards[i].getElementsByClassName('organicSales')[0].value ? cards[i]
                    .getElementsByClassName('organicSales')[0].value : 0,
                sponsoredSales: cards[i].getElementsByClassName('sponsoredSales')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredSales')[0].value : 0,
                overAllOrders: (cards[i].getElementsByClassName('organicOrders')[0].value ? Number(cards[i]
                    .getElementsByClassName('organicOrders')[0].value) : 0) + (cards[i].getElementsByClassName(
                    'sponsoredOrders')[0].value ? Number(cards[i].getElementsByClassName('sponsoredOrders')[
                    0].value) : 0),
                overAllSales: (cards[i].getElementsByClassName('organicSales')[0].value ? Number(cards[i]
                    .getElementsByClassName('organicSales')[0].value) : 0) + (cards[i].getElementsByClassName(
                    'sponsoredSales')[0].value ? Number(cards[i].getElementsByClassName('sponsoredSales')[0]
                    .value) : 0),
                roas: Number(cards[i].getElementsByClassName('spend')[0].value) == 0 ? 0 : (cards[i]
                    .getElementsByClassName('sponsoredSales')[0].value ? Number(cards[i].getElementsByClassName(
                        'sponsoredSales')[0].value) : 0) / (cards[i].getElementsByClassName('spend')[0].value ?
                    Number(cards[i].getElementsByClassName('spend')[0].value) : 0),
            }
        } else {
            var report = {
                task: cards[i].getElementsByClassName('task')[0].value ? cards[i].getElementsByClassName('task')[0]
                    .value : "",
            }
        }
        reports.push(report);
        console.log("report is " + report);
    }

    var clientName = getValue('clientName');
    var projectName = getValue('projectName');
    var resourceName = getValue('resourceName');
    var productName = getValue('productName');
    var statsDatePeriod = getValue('statsDatePeriod');
    var projectStartDate = getValue('statsDatePeriod');
    var projectSelected = getValue('selectProject');
    var projectType = $("input:radio[name=projectType]:checked").val();
    var reportData = reports;

    $.ajax({
        type: 'POST',
        url: '../../assets/php/reportAddition.php',
        data: {
            clientName: clientName,
            projectName: projectName,
            statsDatePeriod: statsDatePeriod,
            projectStartDate: projectStartDate,
            resourceName: resourceName,
            productName: productName,
            reportData: reportData,
            reportType: reportType,
            projectType: projectType,
            projectSelected: projectSelected
        },
        beforeSend: function() {
            $('.loader').fadeIn();
        },
        success: function(response) {
            console.log(response);
            if (response.trim() == "success") {
                $('.loader').fadeOut();
                swal("Success!", "Report Added!", "success")
                    .then((value) => {
                        location.reload();
                    });
            } else {
                $('.loader').fadeOut();
                swal("Error!", "An error occurred, please try again!", "error");
            }
        },
        error: function(response) {
            console.log("error is ");
            console.log(response);
        }
    });
}

function getValue(name) {
    if ($("#" + name).length == 0) {
        return "";
    } else {
        return $("#" + name).val();
    }
}

function addReportCard() {
    var reportCardDetail =
        '<div class="card card-info reportDetailCard"> <div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
        "'" + ' .card' + "'" +
        ').remove()"><i class="fas fa-trash"></i></button></div></div><div class="card-body"><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="asinSku">Campaign Name</label><input type="text" class="form-control asinSku" name="asinSku" placeholder="Enter Campaign Name"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="impressions">Impressions</label><input type="number" class="form-control impressions" name="impressions" placeholder="Enter Impressions"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="clicks">Clicks</label><input type="number" class="form-control clicks" name="clicks" placeholder="Enter Clicks"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="spend">Spend</label><input type="number" class="form-control spend" name="spend" placeholder="Enter Cost"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="organicOrders">Organic Orders</label><input type="number" class="form-control organicOrders" name="organicOrders" placeholder="Enter Organic Orders"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="sponsoredOrders">Sponsored Orders</label><input type="number" class="form-control sponsoredOrders" name="sponsoredOrders" placeholder="Enter Sponsored Orders"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="organicSales">Organic Sales</label><input type="number" class="form-control organicSales" name="organicSales" placeholder="Enter Organic Sales"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="sponsoredSales">Sponsored Sales</label><input type="number" class="form-control sponsoredSales" name="sponsoredSales" placeholder="Enter Sponsored Sales"></div></div></div></div></div>';
    $("#reportCardBody").append(reportCardDetail);
}

function addTaskCard() {
    var taskCardDetail =
        '<div class="card card-info reportDetailCard"><div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
        "'" + '.card' + "'" +
        ').remove()"> <i class="fas fa-trash"></i> </button></div></div><div class="card-body"> <div class="row"> <div class="col-md-12 col-sm-12"><div class="form-group"> <label for="taskBody">Enter Task</label> <textarea class="form-control task" name="task" rows="3"></textarea></div></div></div></div></div>';
    $("#taskCardBody").append(taskCardDetail);
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