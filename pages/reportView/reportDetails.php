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
      $clientName = $row['clientName'];
      $projectName = $row['projectName'];
      $projectStartDate = date("d-m-Y", strtotime($row['projectStartDate']));
      $productName = $row['productName'];

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
            <div class="row">
                <div class="col-md-12">


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Report Filters</h3>

                            <div class="card-tools">
                                <button id="filterCard" type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Type</label>
                                            <select id="date_type" class="form-control" required>
                                                <option value="" selected disabled>Select date type</option>
                                                <option value="date" value="date">Fixed</option>
                                                <option value="range" value="range">Range</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Filter By</label>
                                            <select id="filter_by" class="form-control" required>
                                                <option value="0">Report Date</option>
                                                <option value="1">Stat Date</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 rangeFilter" hidden>
                                                <div class="form-group">
                                                    <label for="reportFromDate">From Date</label>
                                                    <input type="date" class="form-control reportFromDate"
                                                        name="reportFromDate" id="reportFromDate"
                                                        placeholder="Enter Date">
                                                </div>
                                            </div>
                                            <div class="col-md-6 rangeFilter" hidden>
                                                <div class="form-group">
                                                    <label for="reportToDate">To Date</label>
                                                    <input type="date" class="form-control reportToDate"
                                                        name="reportToDate" id="reportToDate" placeholder="Enter Date">
                                                </div>
                                            </div>
                                            <div class="col-md-12 dateFilter" hidden>
                                                <div class="form-group">
                                                    <label for="reportDate">Date:</label>
                                                    <input type="date" class="form-control reportDate" name="reportDate"
                                                        id="reportDate" placeholder="Enter Date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary float-right" id="applyFilter"
                                            name="applyFilter">Apply Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="invoice p-3 mb-3">
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <address>
                                    F3, 298 Romford Road<br>
                                    London, E7 9HD<br>
                                    Email: info@estoresexperts.com<br>
                                    Mobile: +44 2035003475<br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <img src="../../assets/images/logo_1.png" alt="Invoice logo"
                                    style="height: 100px; margin: 10px;">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col" style="text-align: right;">
                                <span><b>Report Type: </b><?= $row['reportType'] ?></span><br>
                                <span><b>Client Name: </b><?= $row['clientName'] ?></span><br>
                                <span><b>Project Name: </b><?= $row['projectName'] ?></span><br>
                                <span><b>Project Start Date:
                                    </b><?= date("d-m-Y", strtotime($row['projectStartDate'])) ?></span><br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <br>
                        <hr>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered">
                                    <?php if ($row['reportType'] == "STATS") { ?>
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th colspan="12" rowspan="2" style="vertical-align: middle;">
                                                <?= $row['productName'] ?></th>
                                            <th colspan="6">Sales Stats</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">In Units</th>
                                            <th colspan="3">In Amount</th>
                                        </tr>
                                        <tr>
                                            <th>Report Date</th>
                                            <th>Stats Date</th>
                                            <th>Resource Name</th>
                                            <th>Campaign Name</th>
                                            <th>Impressions</th>
                                            <th>Clicks</th>
                                            <th>Spend</th>
                                            <th>Sponsored Sales</th>
                                            <th>CTR(%)</th>
                                            <th>CPC</th>
                                            <th>ACOS(%)</th>
                                            <th>ROAS(%)</th>
                                            <th>Organic Orders</th>
                                            <th>Sponsored Orders</th>
                                            <th>Overall Orders</th>
                                            <th>Organic Sales</th>
                                            <th>Sponsored Sales</th>
                                            <th>Overall Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportCardBody">
                                    </tbody>
                                    <?php } else { ?>
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th colspan="4" style="vertical-align: middle;"><?= $row['productName'] ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Stats Date</th>
                                            <th>Resource Name</th>
                                            <th>Task Details</th>
                                        </tr>
                                    </thead>
                                    <tbody id="taskCardBody">

                                    </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.content -->
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"
                        onclick="downloadReport();">
                        <i class="fas fa-download"></i> Download PDF
                    </button><br>
                </div>
            </div>
        </div>
    </section>

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
var pdfData = [];


$(document).ready(function() {
    $("#filterCard").click();

    $("#filter_form").on('submit', function(e) {
        e.preventDefault();
        applyFilter();
    })

    $("#date_type").on('change', function() {
        if ($(this).val() === "date") {
            $(".rangeFilter").attr("hidden", true);
            $(".dateFilter").attr("hidden", false);
            $("#reportFromDate").prop("required", false);
            $("#reportToDate").prop("required", false);
            $("#reportDate").prop("required", true);
        } else if ($(this).val() === "range") {
            $(".rangeFilter").attr("hidden", false);
            $(".dateFilter").attr("hidden", true);
            $("#reportFromDate").prop("required", true);
            $("#reportToDate").prop("required", true);
            $("#reportDate").prop("required", false);
        }
    })

    for (var i = 0; i < reports.length; i++) {
        var reportDateForm = reports[i].reportDate.split("-").reverse().join("-");
        var statsDateForm = reports[i].statsDatePeriod.split("-").reverse().join("-");
        if (reportType == "STATS") {
            var reportCardDetail = '<tr><td>' + reportDateForm + '</td><td>' + statsDateForm + '</td><td>' +
                reports[i].resourceName +
                '</td><td>' + reports[i].asinSku + '</td><td>' + Number(reports[i].impressions) + '</td><td>' +
                Number(reports[i].clicks) + '</td><td>' + reports[i].spend + '</td><td>' + reports[i]
                .sponsoredSales + '</td><td>' + reports[i].ctr +
                '</td><td>' + reports[i].cpc + '</td><td>' + reports[i].acos + '</td><td>' + reports[i].roas +
                '</td><td>' + Number(reports[i].organicOrders) + '</td><td>' + Number(reports[i]
                    .sponsoredOrders) + '</td><td>' + Number(reports[i].overallOrders) + '</td><td>' + reports[
                    i].organicSales + '</td><td>' + reports[i].sponsoredSales + '</td><td>' + reports[i]
                .overallSales + '</td></tr>';
            pdfData.push(reports[i]);
            $("#reportCardBody").append(reportCardDetail);
        } else if (reportType == "TASK") {
            var taskCardDetail = '<tr><td>' + statsDateForm + '</td><td>' + reports[i].resourceName +
                '</td><td>' + reports[i].tasks + '</td></tr>';
            pdfData.push(reports[i]);
            $("#taskCardBody").append(taskCardDetail);
        }
    }

});

function applyFilter() {
    pdfData = [];
    var filterVal = $("#date_type").val();
    if (reportType == "STATS") {
        $("#reportCardBody").html("");
        for (var i = 0; i < reports.length; i++) {
            var reportDateForm = reports[i].reportDate.split("-").reverse().join("-");
            var statsDateForm = reports[i].statsDatePeriod.split("-").reverse().join("-");
            if ($("#filter_by").val() === "0") {
                filter_date = reports[i].reportDate;
            } else {
                filter_date = reports[i].statsDatePeriod;
            }
            if (filterVal == "date") {
                if (filter_date == $('#reportDate').val()) {
                    var reportCardDetail = '<tr><td>' + reports[i].reportDate + '</td><td>' + reports[i]
                        .statsDatePeriod + '</td><td>' + reports[i].resourceName +
                        '</td><td>' + reports[i].asinSku + '</td><td>' + Number(reports[i].impressions) + '</td><td>' +
                        Number(reports[i].clicks) + '</td><td>' + reports[i].spend + '</td><td>' + reports[i]
                        .sponsoredSales + '</td><td>' + reports[i].ctr +
                        '</td><td>' + reports[i].cpc + '</td><td>' + reports[i].acos + '</td><td>' + reports[i].roas +
                        '</td><td>' + Number(reports[i].organicOrders) + '</td><td>' + Number(reports[i]
                            .sponsoredOrders) + '</td><td>' + Number(reports[i].overallOrders) + '</td><td>' + reports[
                            i].organicSales + '</td><td>' + reports[i].sponsoredSales + '</td><td>' + reports[i]
                        .overallSales + '</td></tr>';
                    pdfData.push(reports[i]);
                    $("#reportCardBody").append(reportCardDetail);
                }
            } else if (filterVal == "range") {
                var fromDate = $('#reportFromDate').val() == "" ? new Date("1970-01-01") : new Date($('#reportFromDate')
                    .val());
                var toDate = $('#reportToDate').val() == "" ? new Date() : new Date($('#reportToDate').val());
                if ((fromDate <= new Date(filter_date)) && (toDate >= new Date(filter_date))) {
                    var reportCardDetail = '<tr><td>' + reports[i].reportDate + '</td><td>' + reports[i]
                        .statsDatePeriod + '</td><td>' + reports[i].resourceName +
                        '</td><td>' + reports[i].asinSku + '</td><td>' + reports[i].impressions + '</td><td>' + reports[
                            i].clicks + '</td><td>' + reports[i].spend + '</td><td>' + reports[i].sponsoredSales +
                        '</td><td>' + reports[i].ctr + '</td><td>' +
                        reports[i].cpc + '</td><td>' + reports[i].acos + '</td><td>' + reports[i].roas + '</td><td>' +
                        reports[i].organicOrders + '</td><td>' + reports[i].sponsoredOrders + '</td><td>' + reports[i]
                        .overallOrders + '</td><td>' + reports[i].organicSales + '</td><td>' + reports[i]
                        .sponsoredSales + '</td><td>' + reports[i].overallSales + '</td></tr>';
                    pdfData.push(reports[i]);
                    $("#reportCardBody").append(reportCardDetail);
                }
            }
        }
    } else if (reportType == "TASK") {
        $("#taskCardBody").html("");
        for (var i = 0; i < reports.length; i++) {
            if ($("#filter_by").val() === "0") {
                filter_date = reports[i].reportDate;
            } else {
                filter_date = reports[i].statsDatePeriod;
            }
            if (filterVal == "date") {
                if (filter_date == $('#reportDate').val()) {
                    var taskCardDetail = '<tr><td>' + reports[i].statsDatePeriod + '</td><td>' + reports[i]
                        .resourceName +
                        '</td><td>' + reports[i].tasks + '</td></tr>';
                    $("#taskCardBody").append(taskCardDetail);
                    pdfData.push(reports[i]);
                }
            } else if (filterVal == "range") {
                var fromDate = $('#reportFromDate').val() == "" ? new Date("1970-01-01") : new Date($('#reportFromDate')
                    .val());
                var toDate = $('#reportToDate').val() == "" ? new Date() : new Date($('#reportToDate').val());
                if ((fromDate <= new Date(filter_date)) && (toDate >= new Date(filter_date))) {
                    var taskCardDetail = '<tr><td>' + reports[i].statsDatePeriod + '</td><td>' + reports[i]
                        .resourceName +
                        '</td><td>' + reports[i].tasks + '</td></tr>';
                    $("#taskCardBody").append(taskCardDetail);
                    pdfData.push(reports[i]);
                }
            }
        }
    }
}

function downloadReport() {
    $(".loader").fadeIn();
    $.ajax({
        type: 'POST',
        url: "../../assets/php/generateReport.php",
        data: {
            pdfData: pdfData,
            reportType: '<?= $reportType; ?>',
            clientName: '<?= $clientName; ?>',
            projectName: '<?= $projectName; ?>',
            projectStartDate: '<?= $projectStartDate; ?>',
            productName: '<?= $productName; ?>'
        },
        success: function(response) {
            $(".loader").fadeOut();
            if (response != "failed") {
                window.open('../../assets/php/' + response + "?" + +new Date().getTime(), '_self');
            } else {
                swal("Error!", "An error occurred please try again!", "error");
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