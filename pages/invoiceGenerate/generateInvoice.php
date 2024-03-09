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
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="invoiceNumber">Invoice #</label>
                                            <input type="text" name="invoiceNumber" id="invoiceNumber"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Type</label>
                                            <select id="recurring" class="form-control">
                                                <option value="0">One-Time Project</option>
                                                <option value="1">On-Going Project</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Invoice Date</label>
                                            <input type="date" name="invoiceDate" id="invoiceDateInput"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Payment Due</label>
                                            <input type="date" name="paymentDue" id="paymentDateInput"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="invoiceNumber">Company</label>
                                            <select class="form-control custom-select companySelect" id="companySelect">
                                                <option value="1">EStoresExperts</option>
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
                        or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                        if(mysqli_num_rows($resultCustomers) > 0 ){
                          while($rowCustomers = mysqli_fetch_array($resultCustomers)){
                            ?>
                                                <option value="<?= $rowCustomers['id'] ?>"><?= $rowCustomers['name'] ?>
                                                </option>
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
                                            <textarea name="notes" rows="4" class="form-control" id="notes"></textarea>
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
                                    <input type="text" name="customerName" id="customerName" class="form-control">
                                </div>
                                <?php if ($_SESSION["userType"] == "0") {
                    ?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="customerEmail">Email</label>
                                            <input type="text" name="customerEmail" id="customerEmail"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="customerMobile">Mobile</label>
                                            <input type="number" name="customerMobile" id="customerMobile"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <?php
                  }else {
                    ?>
                                <input type="text" name="customerEmail" id="customerEmail" class="form-control" hidden>
                                <input type="number" name="customerMobile" id="customerMobile" class="form-control"
                                    hidden>
                                <?php
                  }
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
                                    <!-- Services -->
                                    <div class="row" id="product-1">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Service - 1</h3>

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
                                                                    name="productSelect" id="productSelect-1"
                                                                    onchange="updateProductDescription(1);">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="productDescription">Service
                                                                    Description</label>
                                                                <textarea name="productDescription"
                                                                    id="productDescription-1" class="form-control"
                                                                    disabled></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Service price (£)</label>
                                                                <input type="number" name="productCostPrice"
                                                                    id="productCostPrice-1" class="form-control"
                                                                    placeholder="Enter cost price per service"
                                                                    onkeyup="updateProductTotal(1);">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Selling price (£)</label>
                                                                <input type="number" name="productSellingPrice"
                                                                    id="productSellingPrice-1" class="form-control"
                                                                    placeholder="Enter selling price per service"
                                                                    onkeyup="updateProductTotal(1);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="inputName">Quantity</label>
                                                                <input type="number" name="productQuantity"
                                                                    id="productQuantity-1" class="form-control"
                                                                    placeholder="Enter service quantity"
                                                                    onkeyup="updateProductTotal(1);" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 text-right">
                                                            <span><b>Service Cost Price: </b><span></span>£ <span
                                                                    id="product-1-cost">0.00</span></span><br><br>
                                                            <span><b>Service Selling Price: </b><span></span>£ <span
                                                                    id="product-1-total">0.00</span></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (right) -->
                                    </div>
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
                                    <!-- Products -->
                                    <div class="row" id="payment-1">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Payment - 1</h3>

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
                                                                    id="paymentSelect-1">
                                                                    <option value="1">Bank Payment</option>
                                                                    <option value="2">Cash Payment</option>
                                                                    <option value="3">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="paymentAmount">Payment Amount (£)</label>
                                                                <input type="number" name="paymentAmount"
                                                                    id="paymentAmount-1"
                                                                    class="form-control paymentAmount"
                                                                    placeholder="Enter payment amount"
                                                                    onkeyup="updatePaymentTotal();">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label>Payment Date</label>
                                                                    <input type="date" name="paidDate" id="paidDate-1"
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
                                    <!-- /.Products -->
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
                                            <input type="text" id="attachments-list" hidden value="[]">
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
                                        <td>&nbsp; £ <span id="orderTotal">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td><b>PAID: </b></td>
                                        <td>&nbsp; £ <span id="paymentTotal">0.00</span></td>
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
                                <button type="submit" class="btn btn-primary float-right">GENERATE INVOICE</button>
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

<style media="screen">
::-webkit-datetime-edit-year-field:not([aria-valuenow]),
::-webkit-datetime-edit-month-field:not([aria-valuenow]),
::-webkit-datetime-edit-day-field:not([aria-valuenow]) {
    color: transparent;
}
</style>