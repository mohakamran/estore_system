<?php
session_start();
if (isset($_SESSION['userType'])) {

  ini_set('max_execution_time', '20');
  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';

  include('../../assets/php/connection.php');

  $invoiceId = $_GET['invoice'];
  $result = mysqli_query($con, " SELECT * FROM invoice WHERE id = '$invoiceId'")
  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Invoice</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Invoice</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">

                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-6">
                      <?php
                      if ($row['company'] == 1) {
                        ?>
                        <img src="../../assets/images/logo_1.png" alt="Invoice logo" style="height: 50px; margin: 10px;">
                        <?php
                      } else {
                        ?>
                        <img src="../../assets/images/logo_2.png" alt="Invoice logo" style="height: 100px; margin: 10px;">
                        <?php
                      }
                      ?>
                    </div>
                    <div class="col-6" style="text-align: right;">
                      <h1>INVOICE</h1>
                    </div>
                  </div><br><br>
                  <hr>
                  <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                      <address>
                        F3, 298 Romford Road<br>
                        London, E7 9HD<br>
                        Phone: 020 3500 3475<br>
                        Email: info@estoresexperts.com<br>
                      </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      INVOICE TO
                      <address>
                        <strong><?= $row['customerName'] ?></strong><br>
                        <?php
                        if ($_SESSION["userType"] == "0") {
                          ?>
                          Phone: <?= $row['customerMobile'] ?><br>
                          Email: <?= $row['customerEmail'] ?>
                          <?php
                        }
                        ?>
                      </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      <b>Invoice #<?php echo $row['invoiceID']; ?></b><br>
                      <?php
                      if ($row['referenceNumber'] != null) {
                        ?>
                        <b>Reference Number: </b><?php echo $row['referenceNumber']; ?><br>
                        <?php
                      }
                      ?>
                      <b>Invoice Date:</b>
                      <?php
                      $date = date_create($row["invoiceDate"]);
                      echo date_format($date, "d-m-Y"); ?>
                      <br>
                      <b>Payment Due:</b>
                      <?php
                      $date = date_create($row["paymentDate"]);
                      echo date_format($date, "d-m-Y"); ?>
                      <br>
                      <b>Payment Status:</b> <?php if ($row['status']) {
                        echo "Paid";
                      } else {
                        echo "Pending";
                      } ?><br>
                    </div>
                    <!-- /.col -->
                  </div><br>
                  <!-- /.row -->

                  <!-- Table row -->
                  <div class="row">
                    <div class="col-12 table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Quantity</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          $productId = (explode(",", $row['productID'], -1));
                          $productQty = (explode(",", $row['productQuantity'], -1));
                          $productPriceArray = (explode(",", $row['productSellingPrice'], -1));
                          $orderTotal = 0;
                          for ($index = 0; $index < sizeof($productId); $index++) {

                            $productSearch = trim($productId[$index]);
                            $resultProduct = mysqli_query($con, " SELECT * FROM product WHERE id = '$productSearch'")
                            or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                            if (mysqli_num_rows($resultProduct) > 0) {
                              while ($rowProduct = mysqli_fetch_array($resultProduct)) {
                                $productSubtotal = (float) trim($productPriceArray[$index]);
                                $orderTotal = $orderTotal + $productSubtotal;
                                ?>
                                <tr>
                                  <td><?= trim($productQty[$index]); ?></td>
                                  <td><?= $rowProduct['productName'] ?></td>
                                  <td><?= $rowProduct['productDescription'] ?></td>
                                  <td>£ <?= number_format($productSubtotal, 2) ?></td>
                                </tr>
                                <?php
                              }
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div><br>
                  <!-- /.row -->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th>Total:</th>
                            <td>£ <?php echo number_format($orderTotal, 2); ?></td>
                          </tr>
                          <?php
                          $paymentType = (explode(",", $row['paymentType'], -1));
                          $paymentAmount = (explode(",", $row['paymentAmount'], -1));
                          $paidDate = (explode(",", $row['paidDate'], -1));
                          for ($index = 0; $index < sizeof($paymentType); $index++) {
                            ?>
                            <tr>
                              <td><?php
                              $paidDateFormatted = date_create($paidDate[$index]);
                              $paidDateFormatted =  date_format($paidDateFormatted, "d-m-Y");
                              if ($paymentType[$index] == '1') {
                                echo "Bank Payment on " . $paidDateFormatted;
                              } else if ($paymentType[$index] == '2') {
                                echo "Cash Payment on " . $paidDateFormatted;
                              } else {
                                echo "Other Payment on " . $paidDateFormatted;
                              } ?></td>
                              <td>£ <?= number_format($paymentAmount[$index], 2) ?></td>
                            </tr>
                            <?php
                          }
                          ?>
                          <tr>
                            <th>Amount Due:</th>
                            <th>£ <?php echo number_format(($row['orderTotal'] - $row['paymentTotal']), 2); ?></th>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div><br>
                  <!-- /.row -->
                  <div class="row">
                    <div class="col-12" style="font-size: 12px;">
                      <hr>
                      <span>
                        <p>
                          <b>Notes to self</b><br>
                          <?=$row['notes']; ?>
                        </p><br><br>
                        <p><b>Terms & Conditions</b><br>
                          • Deposits: All deposits are non-refundable.<br>
                          • Task Duration: Only agreed tasks would be performed by the staff (additional tasks will cost more)<br>
                          • Changes: We will not be responsible for any kind of change done by some of your other staff.<br>
                          • Sales: It is understood that we cannot force the buyers to give us sales, we will help you keep your listings/PPC campaigns optimized and bring your product to 1st page. So sales are not guaranteed (depending on the product’s potential)<br>
                          • Notify us immediately if you feel any unexpected change to your account so it can be checked on-time.<br>
                          • TACOS (Total Advertising Cost of Sales) are not guaranteed until the product has potential and is high quality.<br>
                          • We will not be responsible for any long-term FBA fee on your previous records.<br>
                          • Pay your invoices in time to get uninterrupted services (a project pause may occur in case of no payment, which can affect your selling account’s performance/health.<br>
                          • Meetings: You can have bi-weekly meetings with your resource to discuss project stats and goals.<br>
                          • Always, keep higher management in loop while contacting any of your resource handling your account.<br>
                        </p>
                      </span><br>
                      <div style="position:relative; width: 100%; text-align: center;">
                        <span>Global Wide Services LTD. T/A E-Stores Experts, Registered in England & Wales number: 13508652</span>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div><br>

                  <!-- this row will not appear when printing -->
                  <?php
                  if ($_SESSION["userType"] == "0") {
                    ?>
                    <div class="row no-print">
                      <div class="col-12">
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" onclick="downloadInvoice(<?= $row['invoiceID'] ?>);">
                          <i class="fas fa-download"></i> Download PDF
                        </button>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <!-- /.invoice -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <script type="text/javascript">
      $(document).ready(function() {
        $("#navInvoiceTree").addClass("menu-open");
        $("#navInvoice").addClass("active");
        $("#navViewInvoice").addClass("active");
      });

      function downloadInvoice(id) {
        if (typeof Android === "undefined") {
          window.open('../../assets/php/invoiceGenerated/' + id + '.pdf?' + new Date().getTime(), '_self');
        } else {
          var url = 'https://structalpha.com/projects/microshield/assets/php/invoiceGenerated/' + id + '.pdf';
          Android.downloadPDF(url, id);
        }
      }
      </script>

      <?php

    }
  }
  include '../elements/footer.php';
} else {
  ?>
  <script>
  window.open('../../', '_self')
  </script>
  <?php
}


?>
