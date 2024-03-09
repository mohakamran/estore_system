<?php

  include_once '../connection.php';
  include('../emailPDF.php');
  $response = "failed";
  $emailDocument = 0;

   date_default_timezone_set('GMT');
  $currentDate = date('Y-m-01');

  $result = mysqli_query($con, "SELECT * FROM invoice WHERE recurring = 1 AND recurred = 0 AND invoiceDate < '$currentDate'")
                  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_array($result)) {
        $invoiceID = time();
  $referenceNumber = null;
  $recurring = $row['recurring'];
  $rootInvoice = $row['rootInvoice'];
  $endDate = $currentDate;
  $invoiceDate = $currentDate;
  $paymentDate = $currentDate;
  $company = $row['company'];
  $employeeID = $row['employeeID'];
  $customerID = $row['customerID'];
  $customerName = $row['customerName'];
  $customerMobile = $row['customerMobile'];
  $customerEmail = $row['customerEmail'];
  $productID = $row['productID'];
  $productCostPrice = $row['productCostPrice'];
  $productSellingPrice = $row['productSellingPrice'];
  $productQuantity = $row['productQuantity'];
  $orderTotal = $row['orderTotal'];
  $paymentTotal = 0;
  $paymentAmount = null;
  $paymentType = null;
  $paidDate = null;
  $status = 0;
  $attachments = null;
  $notes = '';
  $output = '';


  if ($customerID != '') {
    if($recurring == 1){
      $sql = "INSERT INTO invoice (invoiceID, referenceNumber, recurring, rootInvoice, endDate,	invoiceDate,	paymentDate,	company, employeeID, customerID, customerName,	customerMobile, customerEmail, productID, productCostPrice, productSellingPrice, productQuantity, orderTotal, paymentTotal, paymentAmount, paymentType, paidDate, status, attachments, notes)
      VALUES ('$invoiceID', '$referenceNumber', '$recurring', '$rootInvoice', '$endDate', '$invoiceDate', '$paymentDate', '$company', '$employeeID', '$customerID',
        '$customerName', '$customerMobile', '$customerEmail', '$productID', '$productCostPrice', '$productSellingPrice', '$productQuantity', '$orderTotal', '$paymentTotal', '$paymentAmount', '$paymentType', '$paidDate', '$status', '$attachments', '$notes')";
      }else{
        $sql = "INSERT INTO invoice (invoiceID, referenceNumber, recurring, rootInvoice,	invoiceDate,	paymentDate,	company, employeeID, customerID, customerName,	customerMobile, customerEmail, productID, productCostPrice, productSellingPrice, productQuantity, orderTotal, paymentTotal, paymentAmount, paymentType, paidDate, status, attachments, notes)
        VALUES ('$invoiceID', '$referenceNumber', '$recurring', '$rootInvoice', '$invoiceDate', '$paymentDate', '$company', '$employeeID', '$customerID',
          '$customerName', '$customerMobile', '$customerEmail', '$productID', '$productCostPrice', '$productSellingPrice', '$productQuantity', '$orderTotal', '$paymentTotal', '$paymentAmount', '$paymentType', '$paidDate', '$status', '$attachments', '$notes')";
        }
      } else {
        if($recurring == 1){
          $sql = "INSERT INTO invoice (invoiceID, referenceNumber, recurring, rootInvoice, endDate,	invoiceDate,	paymentDate,	company, employeeID, customerName,	customerMobile, customerEmail, productID, productCostPrice, productSellingPrice, productQuantity, orderTotal, paymentTotal, paymentAmount, paymentType, paidDate, status, attachments, notes)
          VALUES ('$invoiceID', '$referenceNumber', '$recurring', '$rootInvoice', '$endDate', '$invoiceDate', '$paymentDate', '$company', '$employeeID','$customerName', '$customerMobile',
            '$customerEmail', '$productID', '$productCostPrice', '$productSellingPrice', '$productQuantity', '$orderTotal', '$paymentTotal', '$paymentAmount', '$paymentType', '$paidDate', '$status', '$attachments', '$notes')";
          }else{
            $sql = "INSERT INTO invoice (invoiceID, referenceNumber, recurring, rootInvoice,	invoiceDate,	paymentDate,	company, employeeID, customerName,	customerMobile, customerEmail, productID, productCostPrice, productSellingPrice, productQuantity, orderTotal, paymentTotal, paymentAmount, paymentType, paidDate, status, attachments, notes)
            VALUES ('$invoiceID', '$referenceNumber', '$recurring', '$rootInvoice', '$invoiceDate', '$paymentDate', '$company', '$employeeID','$customerName', '$customerMobile',
              '$customerEmail', '$productID', '$productCostPrice', '$productSellingPrice', '$productQuantity', '$orderTotal', '$paymentTotal', '$paymentAmount', '$paymentType', '$paidDate', '$status', '$attachments', '$notes')";
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
            <h3>INVOICE</h3>
            </td>
            </tr>
            </table>
            <hr>
            <div class="row invoice-info">
            <table style="position: relative; width: 100%; font-size: 10px; padding: 0px 10px; margin-left: auto; margin-right: auto;">
            <tr style="position: relative; width: 100%;">
            <td style="position: relative; width: 32%;">
            <div class="invoice-col">
            <address>
            F3, 298 Romford Road<br>
            London, E7 9HD<br>
            Phone: 020 3500 3475<br>
            Email: info@estoresexperts.com<br>
            </address>
            </div>
            </td>
            <td style="position: relative; width: 32%;">
            <div class="invoice-col">
            INVOICE TO
            <address>
            <strong>' . $customerName . '</strong><br>
            Phone: ' . $customerMobile . '<br>
            Email: ' . $customerEmail . '
            </address>
            </div>
            </td>
            <td style="position: relative; width: 32%; float: right;">
            <div class="invoice-col">
            <b>Invoice #' . $invoiceID . '</b><br>';

            if ($referenceNumber != "") {
              $output .= '<b>Reference Number: </b>' . $referenceNumber . '<br>';
            }

            $invoiceDate = date_create($invoiceDate);
            $invoiceDate =  date_format($invoiceDate, "d-m-Y");

            $paymentDate = date_create($paymentDate);
            $paymentDate =  date_format($paymentDate, "d-m-Y");

            $output .= '<b>Invoice Date:</b> ' . $invoiceDate . '<br>
            <b>Payment Due:</b> ' . $paymentDate . '<br>
            <b>Payment Status:</b>';

            if ($status == "1") {
              $output .= "Paid";
            } else {
              $output .= "Pending";
            }

            $output .= '<br>
            </div>
            </td>
            </tr>
            </table><br><br>
            </div>
            <div class="row">
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" style="font-size: 10px;">
            <thead>
            <tr>
            <th>Quantity</th>
            <th>Service</th>
            <th>Description</th>
            <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>';

            $productIdArray = (explode(",", $productID, -1));
            $productQtyArray = (explode(",", $productQuantity, -1));
            $productPriceArray = (explode(",", $productSellingPrice, -1));
            $orderTotal = 0;

            for ($index = 0; $index < sizeof($productIdArray); $index++) {

              $productSearch = trim($productIdArray[$index]);
              $resultProduct = mysqli_query($con, " SELECT * FROM product WHERE id = '$productSearch'")
              or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

              if (mysqli_num_rows($resultProduct) > 0) {
                while ($rowProduct = mysqli_fetch_array($resultProduct)) {
                  $productSubtotal = (float) trim($productPriceArray[$index]);
                  $orderTotal = $orderTotal + $productSubtotal;

                  $output .= '<tr>
                  <td>' . trim($productQtyArray[$index]) . '</td>
                  <td>' . $rowProduct['productName'] . '</td>
                  <td>' . $rowProduct['productDescription'] . '</td><td>£ ';
                  $output .=  number_format($productSubtotal, 2);
                  $output .= '</td></tr>';
                }
              }
            }

            $output .= '</tbody>
            </table>
            </div>
            </div><br><br>
            <div class="row">
            <div class="col-xs-6">
            <div class="table-responsive">
            <table class="table" style="font-size: 10px;">
            <tr><th>Total:</th><td>£ ';

            $output .= number_format($orderTotal, 2);
            $output .= '</td></tr>';

            $output .= '<tr>
            <th>Amount Due:</th>
            <th>£ ' . number_format(($orderTotal - $paymentTotal), 2) . '</th>
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

            $file_name = '../invoiceGenerated/' . $invoiceID . '.pdf';
            $pdf = new Pdf();
            $pdf->set_option('isHtml5ParserEnabled', true);
            $pdf->set_option('isRemoteEnabled', true); 
            $pdf->load_html($output);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $file = $pdf->output();
            file_put_contents($file_name, $file);

            if ($customerEmail != "" && $emailDocument == 1) {
              require("../email/class.phpmailer.php");
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
              $mail->Subject = EMAIL_NAME . ' - INVOICE';
              $mail->Body    = '
              <html>
              <body>
              <span>Hi <span style="text-transform:capitalize;"> ' . $customerName . "," . '</span><br><br>Please find the invoice for your order in the attachment.
              </span><br><br><br>
              <b>This is a system generated email do not reply.</b>
              </body>
              </html>';

              $mail->AltBody = EMAIL_NAME . ' - INVOICE';

              if ($mail->send()) {
                $response = "success";
              } else {
                $sqlRemove = "DELETE FROM invoice WHERE invoiceID = '$invoiceID'";
                $con->query($sqlRemove);
              }
            } else {
              $response = "success";
            }
          }
          if ($response == "success") {
            $updated_invoice_id = $row['invoiceID'];
             $sql = "UPDATE invoice SET recurred= 1 WHERE invoiceID = $updated_invoice_id";
        if ($con->query($sql)) {
            echo $response."<br>";
        }else{
            echo mysqli_error($con);
        }
          } else {
            echo mysqli_error($con);
          }

          
        }
    }

        ?>