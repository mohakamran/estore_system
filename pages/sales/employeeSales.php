<?php
session_start();
if($_SESSION['userType'] == '0'){

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';

  include('../../assets/php/connection.php');

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
            <h1>Employee Sales</h1>
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
                <h3 class="card-title">Employee List</h3>
                <h3 class="card-title" style="position: relative; float: right;"><b>Total Revenue: </b>£ <span id="totalRevenue"></span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tableSalary" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Employee ID</th>
                      <th>Employee Name</th>
                      <th>Total Cost</th>
                      <th>Total Sales</th>
                      <th>Revenue</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $totalRevenue = 0;
                    $result= mysqli_query($con, " SELECT * FROM user")
                    or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                    if(mysqli_num_rows($result) > 0 ){
                      while($row = mysqli_fetch_array($result)){
                        $empId = $row['id'];
                        $totalCost = "";
                        $totalSales = 0;
                        $resultInvoice= mysqli_query($con, " SELECT * FROM invoice WHERE employeeID = '$empId' AND invoiceDate BETWEEN '$startDate' AND '$endDate'")
                        or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                        if(mysqli_num_rows($resultInvoice) > 0 ){
                          while($rowInvoice = mysqli_fetch_array($resultInvoice)){

                            $totalSales = $totalSales + $rowInvoice["orderTotal"];
                            $totalCost = $totalCost . $rowInvoice["productCostPrice"];
                          }
                        }

                        $propInvoiceCost = 0;
                        $propInvoiceSale = 0;
                        $propInvoiceRevenue = 0;

                        $resultpropertyInvoice = mysqli_query($con, " SELECT * FROM invoiceproperty WHERE employeeID = '$empId' AND invoiceDate BETWEEN '$startDate' AND '$endDate'")
                        or die('An error occurred! Unable to process this request. '. mysqli_error($con));

                        if(mysqli_num_rows($resultpropertyInvoice) > 0 ){
                          while($rowInvoice = mysqli_fetch_array($resultpropertyInvoice)){
                            $propInvoiceCost += $rowInvoice["orderTotal"] - $rowInvoice["revenue"];
                            $propInvoiceSale += $rowInvoice["orderTotal"];
                            $propInvoiceRevenue += $rowInvoice["revenue"];
                          }
                        }

                        $totalSales += $propInvoiceSale;

                        $totalCostArray = (explode(",", $totalCost, -1));
                        $totalCostAdded = array_sum($totalCostArray) + $propInvoiceCost;

                        $revenue = ($totalSales - $totalCostAdded);
                        $totalRevenue = $totalRevenue + $revenue;
                        ?>

                        <tr>
                          <td><?='TW'.$row['id'] ?></td>
                          <td><?=$row['fname']." ".$row['lname'] ?></td>
                          <td>£ <?=number_format($totalCostAdded,2) ?></td>
                          <td>£ <?=number_format($totalSales,2) ?></td>
                          <td>£ <?=number_format($revenue,2) ?></td>
                          <td>
                            <button type="button" name="button" class="btn btn-info" onclick="viewDetailedSales(<?=$row["id"]; ?>);"><i class="fas fa-eye"></i></button>
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

  <?php
  include '../elements/footer.php';
  ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/datatables-buttons/css/buttons.dataTables.min.css">
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


  <!-- Page script -->
  <script>

  $("#navSalary").addClass("active");

  $(document).ready(function(){
    $("#totalRevenue").html('<?=number_format($totalRevenue, 2); ?>');
  });

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
        },
        {
          extend:    'excelHtml5',
          text:      '<i class="fa fa-file-excel" style="color: #4285F4;"></i>&nbsp;&nbsp;Excel',
          titleAttr: 'Excel',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
        },
        {
          extend:    'csvHtml5',
          text:      '<i class="fas fa-file-csv" style="color: #4285F4;"></i>&nbsp;&nbsp;CSV',
          titleAttr: 'CSV',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
        },
        {
          extend:    'pdfHtml5',
          text:      '<i class="fa fa-file-pdf" style="color: #4285F4;"></i>&nbsp;&nbsp;PDF',
          titleAttr: 'PDF',
          exportOptions: {
            columns: 'th:not(:last-child)'
          },
        }
      ],
      "paging": true,
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


  function viewDetailedSales(id){
    var startDate = '<?=$_GET["start"] ?>';
    var endDate = '<?=$_GET["end"] ?>';
    var url = 'detailedSales.php?employeeID='+id+'&start='+startDate+'&end='+endDate;
    window.open(url ,'_blank');
  }

  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
