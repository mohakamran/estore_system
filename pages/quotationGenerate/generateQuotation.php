<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Generate Quotation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quotation</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form role="form" id="quotationGenerationForm">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Quotation details</h3>

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
                                            <label for="quotationNumber">Quotation #</label>
                                            <input type="text" name="quotationNumber" id="quotationNumber"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Quotation Date</label>
                                            <input type="date" name="quotationDate" id="quotationDate"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="companySelect">Company</label>
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
                                                <option value="" selected>Custom</option>
                                                <?php

                        $resultCustomers = mysqli_query($con, " SELECT * FROM customer")
                          or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                        if (mysqli_num_rows($resultCustomers) > 0) {
                          while ($rowCustomers = mysqli_fetch_array($resultCustomers)) {
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
                                <h3 class="card-title">Quotation Services</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="itemCardBody">

                                        <div class="card card-primary itemDetailsCard">
                                            <div class="card-header">
                                                <h3 class="card-title">Service Details</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        onclick="$(this).closest('.card').remove();"> <i
                                                            class="fas fa-trash"></i> </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="itemName">Service Name</label>
                                                            <input type="text" name="itemName" id="itemName"
                                                                class="form-control itemName"
                                                                placeholder="Enter item name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="itemName">Service Description</label>
                                                            <textarea name="itemDescription" id="itemDescription"
                                                                class="form-control itemDescription"
                                                                placeholder="Enter item description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="itemName">Service Duration(Hrs)</label>
                                                            <input type="number" name="itemDuration" id="itemDuration"
                                                                class="form-control itemDuration"
                                                                placeholder="Enter item duration" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" name="button" class="btn btn-success"
                                    style="float: right; margin-left: 10px;" onclick="addItem();"><i
                                        class="fas fa-plus-square"></i> &nbsp; ADD ITEM</button>
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
                                <h3 class="card-title">Order details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body"><br>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="quotationCostPrice">Quotation Cost Price (£)</label>
                                            <input type="number" name="quotationCostPrice" id="quotationCostPrice"
                                                class="form-control" placeholder="Enter quotation cost price">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="quotationSellingPrice">Quotation Selling Price (£)</label>
                                            <input type="number" name="quotationSellingPrice" id="quotationSellingPrice"
                                                class="form-control" placeholder="Enter quotation selling price">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary">
                                    <label for="checkboxPrimary">
                                        Email to customer
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">GENERATE QUOTATION</button>
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