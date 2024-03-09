<?php
session_start();
if (isset($_SESSION['userType'])) {


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';


  $reportID = $_GET['reportID'];

  include_once '../../assets/php/connection.php';

  $result = mysqli_query($con, "SELECT * FROM reports WHERE id = '$reportID'")
  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_array($result)) {

      $reportType = $row['reportType'];
      $subresult = mysqli_query($con, "SELECT * FROM reportdata WHERE reportRefId = '$reportID'")
      or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

      $detailsArray = [];
      if (mysqli_num_rows($subresult) > 0) {
        while ($subrow = mysqli_fetch_array($subresult)) {
          array_push($detailsArray, $subrow);
        }
      }

      ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report Details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" id="reportForm" action="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Client Details</h3>
                                <div class="card-tools" style="position: relative; top: 10px;">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="clientName">Client Name</label>
                                            <input type="text" class="form-control" id="clientName" name="clientName"
                                                value="<?= $row['clientName'] ?>" placeholder="Enter Client Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="projectName">Project Name</label>
                                            <input type="text" class="form-control" id="projectName" name="projectName"
                                                value="<?= $row['projectName'] ?>" placeholder="Enter Project Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group"> <label for="projectStartDate">Project Start
                                                Date</label> <input type="date" class="form-control projectStartDate"
                                                name="projectStartDate" id="projectStartDate"
                                                value="<?= $row['projectStartDate'] ?>" placeholder="Enter Date"></div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="productName">Product Name</label>
                                            <input type="text" class="form-control" id="productName" name="productName"
                                                value="<?= $row['productName'] ?>" placeholder="Enter Product Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Report Data</h3>
                                <div class="card-tools" style="position: relative; top: 10px;">
                                    <button id="reportCard" type="button" class="btn btn-tool"
                                        data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="reportCardBody">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="taskCardBody">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success float-right"
                                    onclick="editReportCard();">ADD +</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Update Report</button>
                        <br><br>
                    </div>
                    <!-- /.row -->
            </form>
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
<link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css"
    rel="stylesheet" />
<link type="text/css" rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css">
<!-- DataTables -->
<link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../vendor/plugins/datatables-buttons/css/buttons.dataTables.min.css">
<!-- DataTables -->
<script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../vendor/plugins/jszip/jszip.min.js"></script>
<script src="../../vendor/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../vendor/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../vendor/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js"></script>
<script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
<script>
$("#navReportTree").addClass("menu-open");
$("#navReport").addClass("active");
$("#navViewReport").addClass("active");

var reports = <?php echo json_encode($detailsArray) ?>;
var reportType = '<?= $reportType ?>';

$(document).ready(function() {
    for (var i = 0; i < reports.length; i++) {
        console.log(reports[i]);
        if (reportType == "STATS") {
            var reportCardDetail =
                '<div class="card card-info reportDetailCard"> <div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
                "'" + ' .card' + "'" +
                ').remove()"><i class="fas fa-trash"></i></button></div></div><div class="card-body"><div class="row"><div class="col-md-4 col-sm-12"><div class="form-group"><label for="statsDatePeriod">Stats Date Period</label><input type="date" class="form-control statsDatePeriod" name="statsDatePeriod" value="' +
                reports[i].statsDatePeriod +
                '" placeholder="Enter Stats Date Period"></div></div><div class="col-md-4 col-sm-12"><div class="form-group"><label for="resourceName">Resource Name</label><input type="text" class="form-control resourceName" name="resourceName" value="' +
                reports[i].resourceName +
                '" placeholder="Enter Resource Name"></div></div><div class="col-md-4 col-sm-12"><div class="form-group"><label for="reportDate">Report Date</label><input type="date" class="form-control reportDate" name="reportDate" value="' +
                reports[i].reportDate +
                '" placeholder="Enter Report Date"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="asinSku">Campaign Name</label><input type="text" class="form-control asinSku" name="asinSku" value="' +
                reports[i].asinSku +
                '" placeholder="Enter Campaign Name"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="impressions">Impressions</label><input type="number" class="form-control impressions" name="impressions" value="' +
                reports[i].impressions +
                '" placeholder="Enter Impressions"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="clicks">Clicks</label><input type="number" class="form-control clicks" name="clicks" value="' +
                reports[i].clicks +
                '" placeholder="Enter Clicks"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="spend">Spend</label><input type="number" class="form-control spend" name="spend" value="' +
                reports[i].spend +
                '" placeholder="Enter Cost"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="ctr">CTR</label><input type="number" class="form-control ctr" name="ctr" value="' +
                reports[i].ctr +
                '" placeholder="Enter CTR"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="acos">ACOS</label><input type="number" class="form-control acos" name="acos" value="' +
                reports[i].acos +
                '" placeholder="Enter ACOS"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="roas">ROAS</label><input type="number" class="form-control roas" name="roas" value="' +
                reports[i].roas +
                '" placeholder="Enter ROAS"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="organicOrders">Organic Orders</label><input type="number" class="form-control organicOrders" name="organicOrders" value="' +
                reports[i].organicOrders +
                '" placeholder="Enter Organic Orders"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="sponsoredOrders">Sponsored Orders</label><input type="number" class="form-control sponsoredOrders" name="sponsoredOrders" value="' +
                reports[i].sponsoredOrders +
                '" placeholder="Enter Sponsored Orders"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="overAllOrders">Overall Orders</label><input type="number" class="form-control overAllOrders" name="overAllOrders" value="' +
                reports[i].overallOrders +
                '" placeholder="Enter Overall Orders"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="organicSales">Organic Sales</label><input type="number" class="form-control organicSales" name="organicSales" value="' +
                reports[i].organicSales +
                '" placeholder="Enter Organic Sales"></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="sponsoredSales">Sponsored Sales</label><input type="number" class="form-control sponsoredSales" name="sponsoredSales" value="' +
                reports[i].sponsoredSales +
                '" placeholder="Enter Sponsored Sales"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label for="overAllSales">Overall Sales</label><input type="number" class="form-control overAllSales" name="overAllSales" value="' +
                reports[i].overallSales + '" placeholder="Enter Overall Sales"></div></div></div></div></div>';
            $("#reportCardBody").append(reportCardDetail);
        } else if (reportType == "TASK") {
            var taskCardDetail =
                '<div class="card card-info reportDetailCard"><div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
                "'" + '.card' + "'" +
                ').remove()"> <i class="fas fa-trash"></i> </button></div></div><div class="card-body"><div class="row"> <div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="statsDatePeriod">Stats Date Period</label> <input type="date" class="form-control statsDatePeriod" name="statsDatePeriod" value="' +
                reports[i].statsDatePeriod +
                '" placeholder="Enter Stats Date Period"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="resourceName">Resource Name</label> <input type="text" class="form-control resourceName" name="resourceName" value="' +
                reports[i].resourceName +
                '" placeholder="Enter Resource Name"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="reportDate">Report Date</label> <input type="date" class="form-control reportDate" name="reportDate" value="' +
                reports[i].reportDate +
                '" placeholder="Enter Report Date"></div></div></div> <div class="row"> <div class="col-md-12 col-sm-12"><div class="form-group"> <label for="taskBody">Enter Task</label> <textarea class="form-control task" name="task" rows="3">' +
                reports[i].tasks + '</textarea></div></div></div></div></div>';
            $("#taskCardBody").append(taskCardDetail);
        }
    }

    $('#reportForm').validate({
        submitHandler: function() {
            reportAddition();
        },
        rules: {
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
            ctr: {
                required: true
            },
            acos: {
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

    var cards = document.getElementsByClassName('reportDetailCard');
    var reports = [];
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
                    .getElementsByClassName('impressions')[0].value : "",
                clicks: clicks,
                spend: spend,
                ctr: cards[i].getElementsByClassName('ctr')[0].value ? cards[i].getElementsByClassName('ctr')[0]
                    .value : "",
                cpc: spend / clicks,
                acos: cards[i].getElementsByClassName('acos')[0].value ? cards[i].getElementsByClassName('acos')[0]
                    .value : "",
                roas: cards[i].getElementsByClassName('roas')[0].value ? cards[i].getElementsByClassName('roas')[0]
                    .value : "",
                organicOrders: cards[i].getElementsByClassName('organicOrders')[0].value ? cards[i]
                    .getElementsByClassName('organicOrders')[0].value : "",
                organicOrders: cards[i].getElementsByClassName('organicOrders')[0].value ? cards[i]
                    .getElementsByClassName('organicOrders')[0].value : "",
                sponsoredOrders: cards[i].getElementsByClassName('sponsoredOrders')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredOrders')[0].value : "",
                sponsoredOrders: cards[i].getElementsByClassName('sponsoredOrders')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredOrders')[0].value : "",
                overAllOrders: cards[i].getElementsByClassName('overAllOrders')[0].value ? cards[i]
                    .getElementsByClassName('overAllOrders')[0].value : "",
                overAllOrders: cards[i].getElementsByClassName('overAllOrders')[0].value ? cards[i]
                    .getElementsByClassName('overAllOrders')[0].value : "",
                organicOrders: cards[i].getElementsByClassName('organicOrders')[0].value ? cards[i]
                    .getElementsByClassName('organicOrders')[0].value : "",
                organicSales: cards[i].getElementsByClassName('organicSales')[0].value ? cards[i]
                    .getElementsByClassName('organicSales')[0].value : "",
                sponsoredOrders: cards[i].getElementsByClassName('sponsoredOrders')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredOrders')[0].value : "",
                sponsoredSales: cards[i].getElementsByClassName('sponsoredSales')[0].value ? cards[i]
                    .getElementsByClassName('sponsoredSales')[0].value : "",
                overAllOrders: cards[i].getElementsByClassName('overAllOrders')[0].value ? cards[i]
                    .getElementsByClassName('overAllOrders')[0].value : "",
                overAllSales: cards[i].getElementsByClassName('overAllSales')[0].value ? cards[i]
                    .getElementsByClassName('overAllSales')[0].value : "",
                statsDatePeriod: cards[i].getElementsByClassName('statsDatePeriod')[0].value ? cards[i]
                    .getElementsByClassName('statsDatePeriod')[0].value : "",
                reportDate: cards[i].getElementsByClassName('reportDate')[0].value ? cards[i]
                    .getElementsByClassName('reportDate')[0].value : "",
                resourceName: cards[i].getElementsByClassName('resourceName')[0].value ? cards[i]
                    .getElementsByClassName('resourceName')[0].value : "",
            }
            reports.push(report);
        } else {
            var report = {
                statsDatePeriod: cards[i].getElementsByClassName('statsDatePeriod')[0].value ? cards[i]
                    .getElementsByClassName('statsDatePeriod')[0].value : "",
                reportDate: cards[i].getElementsByClassName('reportDate')[0].value ? cards[i]
                    .getElementsByClassName('reportDate')[0].value : "",
                resourceName: cards[i].getElementsByClassName('resourceName')[0].value ? cards[i]
                    .getElementsByClassName('resourceName')[0].value : "",
                task: cards[i].getElementsByClassName('task')[0].value ? cards[i].getElementsByClassName('task')[0]
                    .value : "",
            }
            reports.push(report);
        }
        console.log(reports);
    }

    $.ajax({
        type: 'POST',
        url: '../../assets/php/editReport.php',
        data: {
            clientName: $('#clientName').val(),
            projectName: $('#projectName').val(),
            projectStartDate: $('#projectStartDate').val(),
            productName: $('#productName').val(),
            reportData: reports,
            reportID: <?= $reportID ?>,
            reportType: reportType
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
        }
    });
}

function editReportCard() {
    if (reportType == "STATS") {
        var reportCardDetail =
            '<div class="card card-info reportDetailCard"> <div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
            "'" + '.card' + "'" +
            ').remove()"> <i class="fas fa-trash"></i> </button></div></div><div class="card-body"> <div class="row"> <div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="statsDatePeriod">Stats Date Period</label> <input type="date" class="form-control statsDatePeriod" name="statsDatePeriod"  placeholder="Enter Stats Date Period"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="resourceName">Resource Name</label> <input type="text" class="form-control resourceName" name="resourceName"  placeholder="Enter Resource Name"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="reportDate">Report Date</label> <input type="date" class="form-control reportDate" name="reportDate"  placeholder="Enter Report Date"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="asinSku">Campaign Name</label> <input type="text" class="form-control asinSku" name="asinSku"  placeholder="Enter Campaign Name"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="impressions">Impressions</label> <input type="number" class="form-control impressions" name="impressions"  placeholder="Enter Impressions"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="clicks">Clicks</label> <input type="number" class="form-control clicks" name="clicks"  placeholder="Enter Clicks"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="spend">Spend</label> <input type="number" class="form-control spend" name="spend"  placeholder="Enter Cost"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="ctr">CTR</label> <input type="number" class="form-control ctr" name="ctr"  placeholder="Enter CTR"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="cpc">CPC</label> <input type="number" class="form-control cpc" name="cpc"  placeholder="Enter CPC"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="acos">ACOS</label> <input type="number" class="form-control acos" name="acos"  placeholder="Enter ACOS"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="roas">ROAS</label> <input type="number" class="form-control roas" name="roas"  placeholder="Enter ROAS"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="organicOrders">Organic Orders</label> <input type="number" class="form-control organicOrders" name="organicOrders"  placeholder="Enter Organic Orders"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="sponsoredOrders">Sponsored Orders</label> <input type="number" class="form-control sponsoredOrders" name="sponsoredOrders"  placeholder="Enter Sponsored Orders"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="overAllOrders">Overall Orders</label> <input type="number" class="form-control overAllOrders" name="overAllOrders"  placeholder="Enter Overall Orders"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="organicSales">Organic Sales</label> <input type="number" class="form-control organicSales" name="organicSales"  placeholder="Enter Organic Sales"></div></div></div><div class="row"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="sponsoredSales">Sponsored Sales</label> <input type="number" class="form-control sponsoredSales" name="sponsoredSales"  placeholder="Enter Sponsored Sales"></div></div><div class="col-md-6 col-sm-12"> <div class="form-group"> <label for="overAllSales">Overall Sales</label> <input type="number" class="form-control overAllSales" name="overAllSales" placeholder="Enter Overall Sales"></div></div></div></div></div>';
        $("#reportCardBody").append(reportCardDetail);
    } else if (reportType == "TASK") {
        var taskCardDetail =
            '<div class="card card-info reportDetailCard"><div class="card-header"> <h3 class="card-title">Report Details</h3> <div class="card-tools" style="position: relative; top: 10px;"> <button type="button" class="btn btn-tool" onclick="$(this).closest(' +
            "'" + '.card' + "'" +
            ').remove()"> <i class="fas fa-trash"></i> </button></div></div><div class="card-body"><div class="row"> <div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="statsDatePeriod">Stats Date Period</label> <input type="date" class="form-control statsDatePeriod" name="statsDatePeriod" placeholder="Enter Stats Date Period"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="resourceName">Resource Name</label> <input type="text" class="form-control resourceName" name="resourceName" placeholder="Enter Resource Name"></div></div><div class="col-md-4 col-sm-12"> <div class="form-group"> <label for="reportDate">Report Date</label> <input type="date" class="form-control reportDate" name="reportDate"  placeholder="Enter Report Date"></div></div></div> <div class="row"> <div class="col-md-12 col-sm-12"><div class="form-group"> <label for="taskBody">Enter Task</label> <textarea class="form-control task" name="task" rows="3"></textarea></div></div></div></div></div>';
        $("#taskCardBody").append(taskCardDetail);
    }
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