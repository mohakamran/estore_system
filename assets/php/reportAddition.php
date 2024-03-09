<?php
session_start();
if ($_SESSION['username'] != '') {

  include_once 'connection.php';

  $response = "failed";
  $clientName = $con->real_escape_string($_POST['clientName']);
  $projectName = $con->real_escape_string($_POST['projectName']);
  $statsDatePeriod = $_POST['statsDatePeriod'];
  $projectStartDate = $_POST['projectStartDate'];
  $resourceName = $con->real_escape_string($_POST['resourceName']);
  $productName = $con->real_escape_string($_POST['productName']);
  $reportData = $_POST['reportData'];
  $reportDate = date("Y-m-d");
  $reportType = $_POST["reportType"];
  $projectType = $_POST["projectType"];
  $projectSelected = $_POST["projectSelected"];

  if ($projectType == "New") {
    $repSql = "INSERT INTO `reports`(`reportType`, `clientName`, `projectName`, `projectStartDate`, `productName`)
    VALUES ('$reportType', '$clientName', '$projectName', '$projectStartDate', '$productName')";
    if ($con->query($repSql)) {
      $last_id = $con->insert_id;
      $response = "success";
      if ($reportType == "TASK") {
        $sql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `tasks`) VALUES";
        $flag = 0;
        foreach ($reportData as $report) {
          $flag += 1;
          $includeComma = true;
          if (sizeOf($reportData) == $flag) {
            $includeComma = false;
          }
          $sql = getTaskQuery($sql, $report, $last_id, $statsDatePeriod, $resourceName, $includeComma);
        }
      } else if ($reportType == "STATS") {
        $sql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `asinSku`, `impressions`, `clicks`, `spend`, `ctr`, `cpc`, `acos`, `roas`, `organicOrders`, `sponsoredOrders`, `overallOrders`, `organicSales`, `sponsoredSales`, `overallSales`) VALUES";
        $flag = 0;
        foreach ($reportData as $report) {
          $flag += 1;
          $includeComma = true;
          if (sizeOf($reportData) == $flag) {
            $includeComma = false;
          }
          $sql = getQuery($sql, $report, $last_id, $statsDatePeriod, $resourceName, $includeComma);
        }
      } else {
        echo "Unknown Report Type";
        exit();
      }
      if ($con->query($sql)) {
        $response = "success";
      } else {
        $response = mysqli_error($con);
      }
    } else {
      $response = mysqli_error($con);
      return $response;
    }
  } else if ($projectType == "Existing") {
    if ($reportType == "TASK") {
      $sql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `tasks`) VALUES";
      $flag = 0;
      foreach ($reportData as $report) {
        $flag += 1;
        $includeComma = true;
        if (sizeOf($reportData) == $flag) {
          $includeComma = false;
        }
        $sql = getTaskQuery($sql, $report, $projectSelected, $statsDatePeriod, $resourceName, $includeComma);
      }
    } else if ($reportType == "STATS") {
      $sql = "INSERT INTO `reportdata`(`reportRefId`, `reportDate`, `statsDatePeriod`, `resourceName`, `asinSku`, `impressions`, `clicks`, `spend`, `ctr`, `cpc`, `acos`, `roas`, `organicOrders`, `sponsoredOrders`, `overallOrders`, `organicSales`, `sponsoredSales`, `overallSales`) VALUES";
      $flag = 0;
      foreach ($reportData as $report) {
        $flag += 1;
        $includeComma = true;
        if (sizeOf($reportData) == $flag) {
          $includeComma = false;
        }
        $sql = getQuery($sql, $report, $projectSelected, $statsDatePeriod, $resourceName, $includeComma);
      }
    } else {
      echo "Unknown Report Type";
      exit();
    }
    if ($con->query($sql)) {
      $response = "success";
    } else {
      $response = mysqli_error($con);
    }
  }

  echo $response;
} else {
?>
  <script>
    window.open('../php/logout.php', '_self')
  </script>
<?php
}

function getQuery($sql, $report, $reportRefId, $statsDatePeriod, $resourceName, $includeComma)
{
  $reportDate = date("Y-m-d");
  if ($report["impressions"] == 0)
    $report["impressions"] = 1;
  if ($report["sponsoredSales"] == 0)
    $report["sponsoredSales"] = 1;
  $asinSku = $report["asinSku"];
  $impressions = $report["impressions"];
  $ctr = $report["impressions"] == 0 ? 0 : ($report["clicks"] / $report["impressions"]) * 100;
  $acos = $report["sponsoredSales"] == 0 ? 0 : ($report["spend"] / $report["sponsoredSales"]) * 100;
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
  $sql = $sql . " ($reportRefId,'$reportDate','$statsDatePeriod','$resourceName','$asinSku',$impressions,$clicks,$spend,$ctr,$cpc,$acos,$roas,$organicOrders,$sponsoredOrders,$overAllOrders,$organicSales,$sponsoredSales,$overAllSales)";
  if ($includeComma)
    $sql = $sql . ",";
  return $sql;
}

function getTaskQuery($sql, $report, $reportRefId, $statsDatePeriod, $resourceName, $includeComma)
{
  $reportDate = date("Y-m-d");
  $task = $report["task"];
  $sql = $sql . " ($reportRefId,'$reportDate','$statsDatePeriod','$resourceName','$task')";
  if ($includeComma)
    $sql = $sql . ",";
  return $sql;
}
?>