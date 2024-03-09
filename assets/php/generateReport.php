<?php
session_start();
if ($_SESSION['username'] != '') {

  include('emailPDF.php');

  $response = "failed";

  $pdfData = $_POST["pdfData"];
  $reportType = $_POST["reportType"];
  $clientName = $_POST["clientName"];
  $projectName = $_POST["projectName"];
  $projectStartDate = $_POST["projectStartDate"];
  $productName = $_POST["productName"];

  $output = '<meta name="viewport" content="width=device-width, initial-scale=1">';
  $output .= '<style>' . file_get_contents("pdf_assets/bootstrap.css") . file_get_contents("pdf_assets/fonts.css") . '</style>';
  $output .= '<div class="content">
  <div>
  <div class="row">
  <div class="col-xs-12">
  <div class="invoice p-3 mb-3">
  <div class="row invoice-info">
  <table style="position: relative; width: 100%; font-size: 10px; padding: 0px 10px; margin-left: auto; margin-right: auto;">
  <tr style="position: relative; width: 100%;">
  <td style="position: relative; width: 32%;">
  <div class="invoice-col">
  <address>
  F3, 298 Romford Road<br>
  London, E7 9HD<br>
  Email: info@estoresexperts.com<br>
  Mobile: +44 2035003475<br>
  </address>
  </div>
  </td>
  <td style="position: relative; width: 32%;">
  <div class="invoice-col">
  <img src="https://crmwide.co.uk/estores/assets/images/logo_1.png" alt="Invoice logo" style="height: 50px; margin: 10px;">
  </div>
  </td>
  <td style="position: relative; width: 32%; float: right;">
  <div class="invoice-col" style= "float: right">
  <b>Report Type: ' . $reportType . '</b><br>
  <b>Client Name: ' . $clientName . '</b><br>
  <b>Project Name: ' . $projectName . '</b><br>
  <b>Project Start Date: ' . $projectStartDate . '</b><br>
  </div>
  </td>
  </tr>
  </table><br><br>
  </div>
  <div class="row">
  <div class="col-xs-12 table-responsive">
  <table class="table table-striped" style="font-size: 8px;">';

  if ($reportType == "TASK") {
    $output .= '<thead>
    <tr>
    <th colspan="4">' . $productName . '</th>
    </tr>
    <tr>
    <th>Stats Date</th>
    <th>Resource Name</th>
    <th>Task Details</th>
    </tr>
    </thead>
    <tbody>';

    foreach ($pdfData as $key => $value) {
      $output .= '<tr>
      <td>' . date("d-m-Y", strtotime($value['reportDate'])) . '</td>
      <td>' . $value['resourceName'] . '</td>
      <td>' . $value['tasks'] . '</td>
      </tr>';
    }
  } else if ($reportType == "STATS") {
    $output .= '<thead>
        <tr>
        <th colspan="12" rowspan="2" style="vertical-align: middle;">' . $productName . '</th>
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
        <th>ASIN and SKU</th>
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
    <tbody>';

    foreach ($pdfData as $key => $value) {
      $output .= '<tr>
            <td>' . date("d-m-Y", strtotime($value['reportDate'])) . '</td>
            <td>' . date("d-m-Y", strtotime($value['statsDatePeriod'])) . '</td>
            <td>' . $value['resourceName'] . '</td>
            <td>' . $value['asinSku'] . '</td>
            <td>' . round($value['impressions']) . '</td>
            <td>' . round($value['clicks']) . '</td>
            <td>' . $value['spend'] . '</td>
            <td>' . $value['sponsoredSales'] . '</td>
            <td>' . $value['ctr'] . '</td>
            <td>' . $value['cpc'] . '</td>
            <td>' . $value['acos'] . '</td>
            <td>' . $value['roas'] . '</td>
            <td>' . round($value['organicOrders']) . '</td>
            <td>' . round($value['sponsoredOrders']) . '</td>
            <td>' . round($value['overallOrders']) . '</td>
            <td>' . $value['organicSales'] . '</td>
            <td>' . $value['sponsoredSales'] . '</td>
            <td>' . $value['overallSales'] . '</td>
      </tr>';
    }
  }

  $output .= '</tbody>
  </table>
  </div>
  </div><br><br>
  </div>
  </div>
  </div>
  </div>
  </div>';

  $file_name = 'reportsGenerated/report-' . $_SESSION['id'] . '.pdf';
  $pdf = new Pdf();
  $pdf->set_option('isHtml5ParserEnabled', true);
  $pdf->set_option('isRemoteEnabled', true); 
  $pdf->load_html($output);
  $pdf->setPaper('A4', 'landscape');
  $pdf->render();
  $file = $pdf->output();
  if (file_put_contents($file_name, $file)) {
    $response = $file_name;
  }

  echo $response;
} else {
?>
<script>
window.open('../php/logout.php', '_self')
</script>
<?php
}

?>