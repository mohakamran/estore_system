<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Recurred Invoices</h1>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoice List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableInvoice" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Invoice ID</th>
                                        <th>Added By</th>
                                        <th>Customer Name</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                  include_once '../../assets/php/connection.php';

                  $empID = $_SESSION['id'];

                  $invoiceId = $_GET['invoice'];
                  $result = mysqli_query($con, "SELECT * FROM invoice WHERE rootInvoice = '$invoiceId'")
                  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_array($result)) {
                      $diff = strtotime($row["paymentDate"]) - time();
                      $hours = round($diff / (60 * 60));
                      if ($row['status']) {
                        ?>
                                    <tr class="datatable-invoice-<?= $row["id"]; ?> invoice-paid <?= $hours; ?>">
                                        <?php
                        } else {
                          if ($hours <= 24) {
                            ?>
                                    <tr class="datatable-invoice-<?= $row["id"]; ?> dt-24-h <?= $hours; ?>">
                                        <?php
                            } else if ($hours > 24 && $hours <= 72) {
                              ?>
                                    <tr class="datatable-invoice-<?= $row["id"]; ?> dt-72-h <?= $hours; ?>">
                                        <?php
                              } else {
                                ?>
                                    <tr class="datatable-invoice-<?= $row["id"]; ?> <?= $hours; ?>">
                                        <?php
                                }
                              }

                              ?>
                                        <td>
                                            <?php
                                if ($row['status']) {
                                  echo "Paid";
                                } else {
                                  if (date("Y-m-d") > date($row['paymentDate'])) {
                                    echo "Overdue";
                                  } else {
                                    echo "Pending";
                                  }
                                }
                                ?>
                                        </td>
                                        <td><?php echo $row["invoiceID"]; ?></td>
                                        <td>
                                            <?php
                                $addedName = "";
                                $addedId = $row["employeeID"];
                                $resultEmp = mysqli_query($con, "SELECT fname FROM user WHERE id = '$addedId'")
                                or die('An error occurred! Unable to process this request. ' . mysqli_error($con));
                                if (mysqli_num_rows($resultEmp) > 0) {
                                  while ($rowEmp = mysqli_fetch_array($resultEmp)) {
                                    $addedName = $rowEmp['fname'];
                                  }
                                }
                                echo $addedName;
                                ?>
                                        </td>
                                        <td><?php echo $row["customerName"]; ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($row["invoiceDate"])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row["paymentDate"])); ?></td>
                                        <td>£ <?php echo number_format($row["orderTotal"], 2); ?></td>
                                        <td>
                                            <button type="button" name="button" class="btn btn-info"
                                                onclick="viewInvoice(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i
                                                    class="fas fa-eye"></i></button>
                                            <button type="button" name="button" class="btn btn-primary"
                                                onclick="editInvoice(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i
                                                    class="fas fa-edit"></i></button>
                                            <?php
                                if ($_SESSION["userType"] == "0") {
                                  ?>
                                            <button type="button" name="button" class="btn btn-danger"
                                                onclick="deleteInvoice(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i
                                                    class="fas fa-trash"></i></button>
                                            <?php
                                }
                                ?>
                                        </td>
                                    </tr>
                                    <?php
                          }
                        }

                        ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->