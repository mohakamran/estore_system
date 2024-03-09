<?php
session_start();
if($_SESSION['userType'] == '0'){

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';

  include('../../assets/php/connection.php');

  $employeeID = $_GET['employeeID'];
  $startDate = $_GET['start'];
  $endDate = $_GET['end'];

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sale details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales</li>
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
                <h3 class="card-title">Invoices generated between <?=$startDate ?> to <?=$endDate ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tableSalary" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Invoice ID</th>
                      <th>Customer Name</th>
                      <th>Invoice Date</th>
                      <th>Cost</th>
                      <th>Amount</th>
                      <th>Revenue</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    <script type="text/javascript">
                    var invoiceAttachments = [];
                    var refundAttachments = [];
                    </script>

                    <?php

                    $totalCost = 0;
                    $totalSales = 0;
                    $totalRevenue = 0;
                    $invoiceIndex = 0;

                    $result= mysqli_query($con, " SELECT * FROM user WHERE id = '$employeeID'")
                    or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                    if(mysqli_num_rows($result) > 0 ){
                      while($row = mysqli_fetch_array($result)){
                        $empId = $row['id'];

                        $resultInvoice= mysqli_query($con, " SELECT * FROM invoice WHERE employeeID = '$empId' AND invoiceDate BETWEEN '$startDate' AND '$endDate'")
                        or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                        if(mysqli_num_rows($resultInvoice) > 0 ){
                          while($rowInvoice = mysqli_fetch_array($resultInvoice)){

                            ?>
                            <script type="text/javascript">
                            invoiceAttachments.push(<?=$rowInvoice['attachments']; ?>);
                            </script>
                            <tr>
                              <td>
                                <?php
                                if($rowInvoice['status']){
                                  echo "Paid";
                                }else{
                                  if(date("Y-m-d") > date($rowInvoice['paymentDate'])){
                                    echo "Overdue";
                                  }else {
                                    echo "Pending";
                                  }
                                }
                                ?>
                              </td>
                              <td><?php echo $rowInvoice["invoiceID"]; ?></td>
                              <td><?php echo $rowInvoice["customerName"]; ?></td>
                              <td><?php echo $rowInvoice["invoiceDate"]; ?></td>
                              <td>
                                <?php
                                $costArray = (explode(",", $rowInvoice["productCostPrice"], -1));
                                $costAdded = array_sum($costArray);
                                ?>
                                £ <?=number_format($costAdded,2) ?>
                              </td>
                              <td>£ <?php echo number_format($rowInvoice["orderTotal"],2); ?></td>
                              <td>£ <?php echo number_format(($rowInvoice["orderTotal"] - $costAdded),2); ?></td>
                              <td>
                                <button type="button" name="button" class="btn btn-info" onclick="viewInvoice(<?=$rowInvoice["id"]; ?>);"><i class="fas fa-eye"></i></button>
                                <?php
                                if($rowInvoice['attachments'] != null && $rowInvoice['attachments'] != "" && $rowInvoice['attachments'] != "[]"){
                                  ?>
                                  <button type="button" class="btn btn-primary" onclick="showModal(<?=$rowInvoice["invoiceID"]; ?>, <?=$invoiceIndex; ?>)">
                                    <i class="fas fa-search"></i>
                                  </button>
                                  <?php
                                }
                                ?>
                              </td>
                            </tr>
                            <?php

                            $totalCost = $totalCost + $costAdded;
                            $totalSales = $totalSales + $rowInvoice["orderTotal"];
                            $totalRevenue = $totalRevenue + ($rowInvoice["orderTotal"] - $costAdded);
                          }
                        }


                        $resultInvoice= mysqli_query($con, " SELECT * FROM invoiceproperty WHERE employeeID = '$empId' AND invoiceDate BETWEEN '$startDate' AND '$endDate'")
                        or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                        if(mysqli_num_rows($resultInvoice) > 0 ){
                          while($rowInvoice = mysqli_fetch_array($resultInvoice)){

                            ?>
                            <tr>
                              <td>
                                <?php
                                if($rowInvoice['status']){
                                  echo "Paid";
                                }else{
                                  if(date("Y-m-d") > date($rowInvoice['paymentDate'])){
                                    echo "Overdue";
                                  }else {
                                    echo "Pending";
                                  }
                                }
                                ?>
                              </td>
                              <td><?php echo $rowInvoice["invoiceID"]; ?></td>
                              <td><?php echo $rowInvoice["landlordName"]; ?></td>
                              <td><?php echo $rowInvoice["invoiceDate"]; ?></td>
                              <td>£ <?php echo number_format(($rowInvoice["orderTotal"] - $rowInvoice["revenue"]),2); ?></td>
                              <td>£ <?php echo number_format($rowInvoice["orderTotal"],2); ?></td>
                              <td>£ <?php echo number_format($rowInvoice["revenue"],2); ?></td>
                              <td>
                                <button type="button" name="button" class="btn btn-info" onclick="viewInvoiceProperty(<?=$rowInvoice["id"]; ?>);"><i class="fas fa-eye"></i></button>
                                <?php
                                if($rowInvoice['attachments'] != null && $rowInvoice['attachments'] != "" && $rowInvoice['attachments'] != "[]"){
                                  ?>
                                  <button type="button" class="btn btn-primary" onclick="showModal(<?=$rowInvoice["invoiceID"]; ?>, <?=$invoiceIndex; ?>)">
                                    <i class="fas fa-search"></i>
                                  </button>
                                  <?php
                                }
                                ?>
                              </td>
                            </tr>
                            <?php

                            $totalCost = $totalCost + ($rowInvoice["orderTotal"] - $rowInvoice["revenue"]);
                            $totalSales = $totalSales + $rowInvoice["orderTotal"];
                            $totalRevenue = $totalRevenue + $rowInvoice["revenue"];
                          }
                        }
                        $invoiceIndex++;

                      }
                    }

                    ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4">Total:</th>
                      <th>£ <?=number_format($totalCost,2) ?></th>
                      <th>£ <?=number_format($totalSales,2) ?></th>
                      <th>£ <?=number_format($totalRevenue,2) ?></th>
                      <th></th>
                    </tr>
                  </tfoot>
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

    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Invoice Attachments</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body attachmentModal">
          </div>

        </div>
      </div>
    </div>
    <button type="button" class="btn btn-primary modalButton" data-toggle="modal" data-target="#myModal" hidden></button>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
  include '../elements/footer.php';
  ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/datatables-buttons/css/buttons.dataTables.min.css">
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css">
  <!-- DataTables -->
  <script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../vendor/plugins/jszip/jszip.min.js"></script>
  <script src="../../vendor/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../vendor/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../vendor/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js"></script>


  <!-- Page script -->
  <script>

  $("#navSalary").addClass("active");


  function showModal(invoiceID, id){
    var attachments = invoiceAttachments[id];
    $(".attachmentModal").html('');
    var attContent = '<ul id="lightSlider">';
    for(ar in attachments){
      attContent += '<li data-thumb="../../assets/uploads/Invoice-'+invoiceID+'/'+attachments[ar]+'"><img src="../../assets/uploads/Invoice-'+invoiceID+'/'+attachments[ar]+'" class="img-responsive" width="100%"/></li>'
    }
    attContent += '</ul>';
    $(".attachmentModal").html(attContent);
    $('#lightSlider').lightSlider({
      gallery: true,
      item: 1,
      slideMargin: 0,
      thumbItem: 9,
      auto:true,
      adaptiveHeight: true,
    });
    $(".modalButton").trigger('click');
  }

  function viewInvoice(id){
    window.open('../invoiceView/viewInvoiceDetails.php?invoice='+id,'_blank')
  }

  function viewInvoiceProperty(id){
    window.open('../propertyView/viewInvoiceDetails.php?invoice='+id,'_blank')
  }

  $(function () {
    $('#tableSalary').DataTable({
      dom: 'lBfrtip',
      buttons: [
        {
          extend:    'copyHtml5',
          text:      '<i class="fas fa-copy" style="color: #4285F4;"></i>&nbsp;&nbsp;Copy',
          titleAttr: 'Copy',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
          footer: true
        },
        {
          extend:    'excelHtml5',
          text:      '<i class="fa fa-file-excel" style="color: #4285F4;"></i>&nbsp;&nbsp;Excel',
          titleAttr: 'Excel',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
          footer: true
        },
        {
          extend:    'csvHtml5',
          text:      '<i class="fas fa-file-csv" style="color: #4285F4;"></i>&nbsp;&nbsp;CSV',
          titleAttr: 'CSV',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
          footer: true
        },
        {
          extend:    'pdfHtml5',
          text:      '<i class="fa fa-file-pdf" style="color: #4285F4;"></i>&nbsp;&nbsp;PDF',
          titleAttr: 'PDF',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
          footer: true
        }
      ],
      "paging": false,
      "lengthChange": true,
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'All' ]
      ],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
