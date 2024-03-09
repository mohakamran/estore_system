<?php
session_start();
if ($_SESSION['username'] != '') {

  $response = "failed";

  $output = '';

  date_default_timezone_set('GMT');
  $currentDate = date('Y-m-d');

  include_once 'connection.php';
  include('emailPDF.php');

  $quotationNumber = $_POST['quotationNumber'];
  $referenceNumber = $_POST['referenceNumber'];
  $quotationDate = $_POST['quotationDate'];
  $company = $_POST['company'];
  $employeeID = $_POST['employeeID'];
  $customerID = $_POST['customerID'];
  $customerName = $_POST['customerName'];
  $customerMobile = $_POST['customerMobile'];
  $customerEmail = $_POST['customerEmail'];
  $quotationItems =  $_POST['quotationItems'];
  $quotationCostPrice = $_POST['quotationCostPrice'];
  $quotationSellingPrice = $_POST['quotationSellingPrice'];
  $emailDocument = $_POST['emailDocument'];


  if ($_SESSION["userType"] == "0") {
    if ($customerID != '') {
      $sql = "UPDATE quotation SET
    referenceNumber='$referenceNumber',
    quotationDate='$quotationDate',
    company='$company',
    customerID='$customerID',
    customerName='$customerName',
    customerMobile='$customerMobile',
    customerEmail='$customerEmail',
    quotationItems='$quotationItems',
    costPrice='$quotationCostPrice',
    sellingPrice='$quotationSellingPrice'
    WHERE quotationID = '$quotationNumber'";
    } else {
      $sql = "UPDATE quotation SET
    referenceNumber='$referenceNumber',
    quotationDate='$quotationDate',
    company='$company',
    customerName='$customerName',
    customerMobile='$customerMobile',
    customerEmail='$customerEmail',
    quotationItems='$quotationItems',
    costPrice='$quotationCostPrice',
    sellingPrice='$quotationSellingPrice'
    WHERE quotationID = '$quotationNumber'";
    }
  } else {
    if ($customerID != '') {
      $sql = "UPDATE quotation SET
    referenceNumber='$referenceNumber',
    quotationDate='$quotationDate',
    company='$company',
    customerID='$customerID',
    customerName='$customerName',
    quotationItems='$quotationItems',
    costPrice='$quotationCostPrice',
    sellingPrice='$quotationSellingPrice'
    WHERE quotationID = '$quotationNumber'";
    } else {
      $sql = "UPDATE quotation SET
    referenceNumber='$referenceNumber',
    quotationDate='$quotationDate',
    company='$company',
    customerName='$customerName',
    quotationItems='$quotationItems',
    costPrice='$quotationCostPrice',
    sellingPrice='$quotationSellingPrice'
    WHERE quotationID = '$quotationNumber'";
    }
  }

  if ($con->query($sql)) {

    $output = '<meta name="viewport" content="width=device-width, initial-scale=1">';
    $output .= '<style>' . file_get_contents("pdf_assets/bootstrap.css") . file_get_contents("pdf_assets/fonts.css") . '</style>';
    $output .= '<div class="content">
     <div>
            <div class="row">
            <div class="col-xs-12">
            <div class="invoice p-3 mb-3">
            <table style="position: relative; width: 100%;">
            <tr style="position: relative; width: 100%;">
            <td style="position: relative; width: 50%;">
            <img src="https://crmwide.co.uk/estores/assets/images/logo_1.png" alt="Invoice logo" style="height: 50px; margin: 10px;">
            </td>
            <td style="position: relative; width: 50%; text-align: right; float: right;">
            <h3>QUOTATION</h3>
            </td>
            </tr>
            </table>
            <hr>
    <div class="row invoice-info">
    <table style="position: relative; width: 100%; font-size: 10px; padding: 0px 10px; margin-left: auto; margin-right: auto;">
    <tr style="position: relative; width: 100%;">
    <td style="position: relative; width: 32%;">
    <div class="invoice-col"><br>
    FROM
    <address>
    F3, 298 Romford Road<br>
    London, E7 9HD<br>
    Phone: 020 3500 3475<br>
    Email: info@estoresexperts.com<br>
    </address>
    </div>
    </td>
    <td style="position: relative; width: 32%;">
    <div class="invoice-col"><br>
    QUOTATION TO
    <address>
    <strong>' . $customerName . '</strong><br>
    Phone: ' . $customerMobile . '<br>
    Email: ' . $customerEmail . '
    </address>
    </div>
    </td>
    <td style="position: relative; width: 32%; float: right;">
    <div class="invoice-col">
    <b>Quotation #' . $quotationNumber . '</b><br><br>';

    if ($referenceNumber != "") {
      $output .= '<b>Reference Number: </b>' . $referenceNumber . '<br>';
    }

    $quotationDate = date_create($quotationDate);
    $quotationDate =  date_format($quotationDate, "d-m-Y");

    $output .= '<b>Quotation Date:</b> ' . $quotationDate . '<br>
    </div>
    </td>
    </tr>
    </table><br><br>
    </div>';

    if (!empty($quotationItems)) {
      $output .= '
      <span><b>SERVICE DETAILS:</b></span><br><br>
      <div class="row">
      <div class="col-xs-12 table-responsive">
      <table class="table" style="font-size: 10px;">
      <thead class="thead-light">
      <tr>
      <th>Name</th>
      <th>Description</th>
      </tr>
      </thead>
      <tbody>';

      $items = json_decode($quotationItems);
      for ($index = 0; $index < sizeof($items); $index++) {
        $output .= '
        <tr>
        <td>' . $items[$index]->itemName . '</td>
        <td>' . $items[$index]->itemDescription . '</td>
        </tr>';
      }

      $output .= '</tbody>
      </table>
      </div>
      </div><br>';
    }

    $output .= '<div class="row">
    <div class="col-xs-6">
    <div class="table-responsive">
    <table class="table" style="font-size: 10px;">
    <tr><th>Total:</th>
    <td>£ ' . $quotationSellingPrice . '</td>
    </tr>
    </table>
    </div>
    </div>
    </div><br>
    <div class="row">
    <div class="col-xs-12" style="font-size: 8px;">
    <hr>
    <span>
    <p><b>Terms & Conditions</b><br>
    •	Deposits: All deposits are non-refundable.<br>
    •	Task Duration: Only agreed tasks would be performed by the staff (additional tasks will cost more)<br>
    •	Changes: We will not be responsible for any kind of change done by some of your other staff.<br>
    •	Sales: It is understood that we cannot force the buyers to give us sales, we will help you keep your listings/PPC campaigns optimized and bring your product to 1st page. So sales are not guaranteed (depending on the product’s potential)<br>
    •	Notify us immediately if you feel any unexpected change to your account so it can be checked on-time.<br>
    •	TACOS (Total Advertising Cost of Sales) are not guaranteed until the product has potential and is high quality.<br>
    •	We will not be responsible for any long-term FBA fee on your previous records.<br>
    •	Pay your invoices in time to get uninterrupted services (a project pause may occur in case of no payment, which can affect your selling account’s performance/health.<br>
    •	Meetings: You can have bi-weekly meetings with your resource to discuss project stats and goals.<br>
    •	Always, keep higher management in loop while contacting any of your resource handling your account.<br>
    </p>
    </span><br>
    <div style="position:relative; width: 100%; text-align: center;">
      <span>Global Wide Services LTD. T/A E-Stores Experts, Registered in England & Wales number: 13508652</span>
    </div>
    </div>
    </div><br>
    </div>
    </div>
    </div>
    </div>
    </div>';

    $file_name = 'quotationGenerated/' . $quotationNumber . '.pdf';
    $pdf = new Pdf();
    $pdf->set_option('isHtml5ParserEnabled', true);
    $pdf->set_option('isRemoteEnabled', true); 
    $pdf->load_html($output);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();
    $file = $pdf->output();
    file_put_contents($file_name, $file);

    if ($customerEmail != "" && $emailDocument == 1) {
      require("email/class.phpmailer.php");
      $mail = new PHPMailer();
      //$mail->IsSMTP();
      $mail->Host = EMAIL_HOST;
      $mail->SMTPAuth = true;
      $mail->Port = EMAIL_PORT;
      $mail->Username = EMAIL_USERNAME;
      $mail->Password = EMAIL_PASSWORD;
      $mail->setFrom(EMAIL_USERNAME, EMAIL_NAME);
      $mail->addAddress($customerEmail, $customerName);
      $mail->addReplyTo(EMAIL_USERNAME, EMAIL_NAME);
      $mail->isHTML(true);
      $mail->AddAttachment($file_name);
      $mail->Subject = EMAIL_NAME . ' - QUOTATION';
      $mail->Body    = '
      <html>
      <body>
      <span>Hi <span style="text-transform:capitalize;"> ' . $customerName . "," . '</span><br><br>Please find the quotation for your order in the attachment.
      </span><br><br><br>
      <b>This is a system generated email do not reply.</b>
      </body>
      </html>';

      $mail->AltBody = EMAIL_NAME . ' - QUOTATION';

      if ($mail->send()) {
        $response = "success";
      } else {
        $sqlRemove = "DELETE FROM quotation WHERE quotationID = '$quotationNumber'";
        $con->query($sqlRemove);
      }
    } else {
      $response = "success";
    }
  }
  if ($response == "success") {
    echo $response;
  } else {
    echo mysqli_error($con);
  }
} else {
?>
<script>
window.open('../php/logout.php', '_self')
</script>
<?php
}
?>