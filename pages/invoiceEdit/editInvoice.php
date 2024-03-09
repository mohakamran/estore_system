<?php

$invoiceId = $_GET['invoice'];
$result = mysqli_query($con, " SELECT * FROM invoice WHERE id = '$invoiceId'")
or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $customerID = $row['customerID'];
    $invoiceID = $row['invoiceID'];
    $attachments = $row['attachments'];
    ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Generate Invoice</h1>
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form role="form" id="invoiceGenerationForm">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Invoice details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="invoiceNumber">Invoice #</label>
                                            <input type="text" name="invoiceNumber" id="invoiceNumber"
                                                class="form-control" value="<?= $row['invoiceID']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Type</label>
                                            <select id="recurring" class="form-control">
                                                <option value="0" <?php if ($row['recurring'] == "0") {
                                echo "selected";
                              } ?>>One-Time Project</option>
                                                <option value="1" <?php if ($row['recurring'] == "1") {
                                echo "selected";
                              } ?>>On-Going Project</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Invoice Date</label>
                                            <input type="date" name="invoiceDate" id="invoiceDateInput"
                                                class="form-control" value="<?= $row['invoiceDate']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Payment Due</label>
                                            <input type="date" name="paymentDue" id="paymentDateInput"
                                                class="form-control" value="<?= $row['paymentDate']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="invoiceNumber">Company</label>
                                            <select class="form-control custom-select companySelect" id="companySelect">
                                                <option value="1" <?php if ($row['company'] == "1") {
                                echo "selected";
                              } ?>>EStoresExperts</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select class="form-control select2bs4" style="width: 100%;"
                                                id="customerSelect" name="customerSelect">
                                                <option value="" selected disabled>Select a customer</option>
                                                <?php

                              $resultCustomers = mysqli_query($con, " SELECT * FROM customer")
                              or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                              if (mysqli_num_rows($resultCustomers) > 0) {
                                while ($rowCustomers = mysqli_fetch_array($resultCustomers)) {
                                  ?>
                                                <option value="<?= $rowCustomers['id'] ?>" <?php if ($customerID == $rowCustomers['id']) {
                                    echo "selected";
                                  } ?>><?= $rowCustomers['name'] ?></option>
                                                <?php
                                }
                              }
                              ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea name="notes" rows="4" class="form-control"
                                                id="notes"><?= $row['notes'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customer details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="customerName">Name</label>
                                    <input type="text" name="customerName" id="customerName" class="form-control"
                                        value="<?= $row['customerName']; ?>">
                                </div>
                                <?php if ($_SESSION["userType"] == "0") {
                          ?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="customerEmail">Email</label>
                                            <input type="text" name="customerEmail" id="customerEmail"
                                                class="form-control" value="<?= $row['customerEmail']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="customerMobile">Mobile</label>
                                            <input type="number" name="customerMobile" id="customerMobile"
                                                class="form-control" value="<?= $row['customerMobile']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php }
                        ?>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Service details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div id="productList">
                                    <!-- Products -->
                                    <?php

                            $productIdArray = (explode(",", $row['productID'], -1));
                            $productQtyArray = (explode(",", $row['productQuantity'], -1));
                            $productCostPriceArray = (explode(",", $row['productCostPrice'], -1));
                            $productSellingPriceArray = (explode(",", $row['productSellingPrice'], -1));
                            $orderTotal = 0;

                            for ($index = 0; $index < sizeof($productIdArray); $index++) {
                              $productNumber = $index + 1;
                              $productSearch = trim($productIdArray[$index]);
                              $resultProduct = mysqli_query($con, " SELECT * FROM product WHERE id = '$productSearch'")
                              or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                              if (mysqli_num_rows($resultProduct) > 0) {
                                while ($rowProduct = mysqli_fetch_array($resultProduct)) {
                                  $orderTotal = $orderTotal + $productSellingPriceArray[$index];

                                  ?>

                                    <div class="row" id="product-<?= $productNumber ?>">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Service - <?= $productNumber ?></h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse" data-toggle="tooltip"
                                                            title="Collapse">
                                                            <i class="fas fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputStatus">Service</label>
                                                                <select class="form-control custom-select productSelect"
                                                                    name="productSelect"
                                                                    id="productSelect-<?= $productNumber ?>"
                                                                    onchange="updateProductDescription(<?= $productNumber ?>);">
                                                                    <option value="<?= $rowProduct['id'] ?>" selected>
                                                                        <?= $rowProduct['productName'] ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="productDescription">Service
                                                                    Description</label>
                                                                <textarea name="productDescription"
                                                                    id="productDescription-<?= $productNumber ?>"
                                                                    class="form-control"
                                                                    disabled><?= $rowProduct['productDescription'] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Service price (£)</label>
                                                                <input type="number" name="productCostPrice"
                                                                    id="productCostPrice-<?= $productNumber ?>"
                                                                    value="<?= $productCostPriceArray[$index] ?>"
                                                                    class="form-control"
                                                                    placeholder="Enter cost price per service"
                                                                    onkeyup="updateProductTotal(<?= $productNumber ?>);">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Selling price (£)</label>
                                                                <input type="number" name="productSellingPrice"
                                                                    id="productSellingPrice-<?= $productNumber ?>"
                                                                    value="<?= $productSellingPriceArray[$index] ?>"
                                                                    class="form-control"
                                                                    placeholder="Enter selling price per service"
                                                                    onkeyup="updateProductTotal(<?= $productNumber ?>);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Quantity</label>
                                                                <input type="number" name="productQuantity"
                                                                    id="productQuantity-<?= $productNumber ?>"
                                                                    value="<?= $productQtyArray[$index] ?>"
                                                                    class="form-control"
                                                                    placeholder="Enter service quantity"
                                                                    onkeyup="updateProductTotal(<?= $productNumber ?>);">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 text-right">
                                                            <span><b>Service Cost Price: </b><span></span>£ <span
                                                                    id="product-<?= $productNumber ?>-cost"><?= number_format($productCostPriceArray[$index], 2) ?></span></span><br><br>
                                                            <span><b>Service Selling Price: </b><span></span>£ <span
                                                                    id="product-<?= $productNumber ?>-total"><?= number_format($productSellingPriceArray[$index], 2) ?></span></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (right) -->
                                    </div>

                                    <?php
                                  }
                                }
                              }
                              ?>

                                    <!-- /.Products -->
                                </div>
                                <button type="button" name="button" class="btn btn-success"
                                    style="float: right; margin-left: 10px;" onclick="addProduct();"><i
                                        class="fas fa-plus-square"></i> &nbsp; ADD SERVICE</button>
                                <button type="button" name="button" class="btn btn-danger removeProduct"
                                    style="float: right;" onclick="removeProduct();" disabled><i
                                        class="fas fa-trash"></i> &nbsp; REMOVE SERVICE</button>
                                <br><br>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>



                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Payment details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div id="paymentList">
                                    <!-- Payments -->
                                    <?php

                                $paymentType = (explode(",", $row['paymentType'], -1));
                                $paymentAmount = (explode(",", $row['paymentAmount'], -1));
                                $paidDate = (explode(",", $row['paidDate'], -1));
                                $paymentTotal = 0;
                                for ($index = 0; $index < sizeof($paymentType); $index++) {
                                  $paymentNumber = $index + 1;
                                  $paymentTotal = $paymentTotal + $paymentAmount[$index];
                                  ?>

                                    <div class="row" id="payment-<?= $paymentNumber ?>">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Payment - <?= $paymentNumber ?></h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse" data-toggle="tooltip"
                                                            title="Collapse">
                                                            <i class="fas fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputStatus">Payment Mode</label>
                                                                <select class="form-control custom-select paymentSelect"
                                                                    id="paymentSelect-<?= $paymentNumber ?>">
                                                                    <option value="1" <?php if ($paymentType[$index] == '1') {
                                                      echo "selected";
                                                    } ?>>Bank Payment</option>
                                                                    <option value="2" <?php if ($paymentType[$index] == '2') {
                                                      echo "selected";
                                                    } ?>>Cash Payment</option>
                                                                    <option value="3" <?php if ($paymentType[$index] == '3') {
                                                      echo "selected";
                                                    } ?>>Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="paymentAmount">Payment Amount (£)</label>
                                                                <input type="number" name="paymentAmount"
                                                                    id="paymentAmount-<?= $paymentNumber ?>"
                                                                    value="<?= $paymentAmount[$index] ?>"
                                                                    class="form-control paymentAmount"
                                                                    placeholder="Enter payment amount"
                                                                    onkeyup="updatePaymentTotal();">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label>Payment Date</label>
                                                                    <input type="date" name="paidDate"
                                                                        id="paidDate-<?= $paymentNumber ?>"
                                                                        value="<?= $paidDate[$index] ?>"
                                                                        class="form-control paidDate">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (right) -->
                                    </div>

                                    <?php
                                  }

                                  ?>

                                    <!-- /.Payments -->
                                </div>
                                <button type="button" name="button" class="btn btn-success"
                                    style="float: right; margin-left: 10px;" onclick="addPayment();"><i
                                        class="fas fa-plus-square"></i> &nbsp; ADD PAYMENT</button>
                                <button type="button" name="button" class="btn btn-danger removePayment"
                                    style="float: right;" onclick="removePayment();"><i class="fas fa-trash"></i> &nbsp;
                                    REMOVE PAYMENT</button>
                                <br><br>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>


                <div class="row">
                    <div class="col-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Attachments</h3>
                                <div class="card-tools">
                                    <button id="attachmentsCard" type="button" class="btn btn-tool"
                                        data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" id="attachments-list" hidden>
                                            <input type="file" name="files[]" class="attachments" id="attachments"
                                                multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>

                </div>


                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body"><br>
                                <table>
                                    <tr height="20px">
                                    </tr>
                                    <tr>
                                        <td><b>ORDER TOTAL: </b></td>
                                        <td>&nbsp; £ <span
                                                id="orderTotal"><?php echo number_format($orderTotal, 2); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>PAID: </b></td>
                                        <td>&nbsp; £ <span
                                                id="paymentTotal"><?php echo number_format($paymentTotal, 2); ?></span>
                                        </td>
                                    </tr>
                                </table><br>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary">
                                    <label for="checkboxPrimary">
                                        Email to customer
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">UPDATE INVOICE</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </form>
            <!-- /.form -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
                }
              }
              ?>