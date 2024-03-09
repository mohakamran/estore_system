<?php
session_start();
if ($_SESSION['username'] != '') {

    include_once 'connection.php';

    $response = "failed";

    $clientName = $con->real_escape_string($_POST['clientName']);
    $projectName = $con->real_escape_string($_POST['projectName']);
    $projectStartDate = $_POST['projectStartDate'];
    $productName = $con->real_escape_string($_POST['productName']);
    $reportData = $_POST['reportData'];
    $reportID = $_POST['reportID'];
    $reportType  = $_POST['reportType'];

    $sql = "UPDATE `reports` SET `clientName`='$clientName',`projectName`='$projectName',`projectStartDate`='$projectStartDate',`productName`='$productName' WHERE `id`=$reportID";

    if ($con->query($sql)) {
        $response = "success";
        $sql = "DELETE from `reportdata` WHERE `reportRefId`=$reportID";
        if ($con->query($sql)) {
            if ($reportType == "TASK") {
                $subsql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `tasks`) VALUES";
                $flag = 0;
                foreach ($reportData as $report) {
                    $flag += 1;
                    $includeComma = true;
                    if (sizeOf($reportData) == $flag) {
                        $includeComma = false;
                    }
                    $subsql = getTaskQuery($subsql, $report, $reportID,  $includeComma);
                }
            } else if ($reportType == "STATS") {
                $subsql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `asinSku`, `impressions`, `clicks`, `spend`, `ctr`, `cpc`, `acos`, `roas`, `organicOrders`, `sponsoredOrders`, `overallOrders`, `organicSales`, `sponsoredSales`, `overallSales`) VALUES";
                $flag = 0;
                foreach ($reportData as $report) {
                    $flag += 1;
                    $includeComma = true;
                    if (sizeOf($reportData) == $flag) {
                        $includeComma = false;
                    }
                    $subsql = getQuery($subsql, $report, $reportID,  $includeComma);
                }
            }
            if ($con->query($subsql)) {
                $response = "success";
            } else {
                $response = mysqli_error($con);
            }
        }
    } else {
        $response = mysqli_error($con);
    }

    echo $response;
} else {
?>
    <script>
        window.open('../php/logout.php', '_self')
    </script>
<?php
}


function getQuery($sql, $report, $reportID, $includeComma)
{
    $reportDate = date("Y-m-d");
    if ($report["impressions"] == 0)
        $report["impressions"] = 1;
    if ($report["sponsoredSales"] == 0)
        $report["sponsoredSales"] = 1;
    $asinSku = $report["asinSku"];
    $impressions = $report["impressions"];
    $ctr = ($report["clicks"] / $report["impressions"]) * 100;
    $acos = ($report["spend"] / $report["sponsoredSales"]) * 100;
    $clicks = $report["clicks"];
    $spend = $report["spend"];
    $cpc = $report["cpc"];
    $roas = $report["roas"];
    $organicOrders = $report["organicOrders"];
    $sponsoredOrders = $report["sponsoredOrders"];
    $overAllOrders = $report["overAllOrders"];
    $organicSales = $report["organicSales"];
    $sponsoredSales = $report["sponsoredSales"];
    $overAllSales = $report["overAllSales"];
    $reportDate = $report["reportDate"];
    $statsDatePeriod = $report["statsDatePeriod"];
    $resourceName = $report["resourceName"];
    $sql = $sql . " ($reportID,'$reportDate','$statsDatePeriod','$resourceName','$asinSku',$impressions,$clicks,$spend,$ctr,$cpc,$acos,$roas,$organicOrders,$sponsoredOrders,$overAllOrders,$organicSales,$sponsoredSales,$overAllSales)";
    if ($includeComma)
        $sql = $sql . ",";
    return $sql;
}

function getTaskQuery($sql, $report, $reportID, $includeComma)
{
    $reportDate = date("Y-m-d");
    $task = $report["task"];
    $reportDate = $report["reportDate"];
    $statsDatePeriod = $report["statsDatePeriod"];
    $resourceName = $report["resourceName"];
    $sql = $sql . " ($reportID,'$reportDate','$statsDatePeriod','$resourceName','$task')";
    if ($includeComma)
        $sql = $sql . ",";
    return $sql;
}
?>