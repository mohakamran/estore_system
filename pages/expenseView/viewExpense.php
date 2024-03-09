<?php
session_start();
if (isset($_SESSION['userType']) && $_SESSION['userType'] == '0') {


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';

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
            <h1>View Expense</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense</li>
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
                <h3 class="card-title">Expense List</h3>
                <h3 class="card-title" style="position: relative; float: right;"><b>Total Expense: </b>£ <span id="totalExpense"></span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tableExpense" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="position: relative; width: 10%;">Amount</th>
                      <th style="position: relative; width: 10%;">Date</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    include_once '../../assets/php/connection.php';

                    $result = mysqli_query($con, "SELECT * FROM expense WHERE expenseDate BETWEEN '$startDate' AND '$endDate'")
                      or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      $totalExpense = 0;
                      while ($row = mysqli_fetch_array($result)) {
                        $totalExpense += $row["expenseAmount"];
                    ?>
                        <tr class="datatable-expense-<?= $row["id"]; ?>">
                          <td>£ <?php echo number_format($row["expenseAmount"], 2); ?></td>
                          <td><?php echo date('d-m-Y', strtotime($row["expenseDate"])); ?></td>
                          <td><?php echo $row["expenseDescription"]; ?></td>
                          <td>
                            <button style="margin-bottom: 5px;" type="button" name="button" class="btn btn-info" onclick="viewExpense(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-eye"></i></button>
                            <button style="margin-bottom: 5px;" type="button" name="button" class="btn btn-primary" onclick="editExpense(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-edit"></i></button>
                            <button style="margin-bottom: 5px;" type="button" name="button" class="btn btn-danger" onclick="deleteExpense(<?php echo htmlentities(json_encode($row["id"])); ?>);"><i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                    <?php
                      }
                      $totalExpense = number_format($totalExpense, 2);
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
  <!-- DataTables -->
  <script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script>
    $("#navExpenseTree").addClass("menu-open");
    $("#navExpense").addClass("active");
    $("#navViewExpense").addClass("active");

    $(document).ready(function() {
      $("#totalExpense").html('<?= $totalExpense; ?>');
    });

    var table;

    $(function() {
      table = $('#tableExpense').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

    function viewExpense(id) {
      window.open('expenseDetails.php?expenseID=' + id, '_self')
    }

    function editExpense(id) {
      window.open('editExpense.php?expenseID=' + id, '_self');
    }

    function deleteExpense(id) {

      var alertText = "";
      var deleteUrl = "";
      deleteUrl = "../../assets/php/expenseRemove.php";
      alertText = "The expense would be removed from the database!"

      swal({
          title: "Are you sure?",
          text: alertText,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              type: 'POST',
              url: deleteUrl,
              data: {
                expenseID: id
              },
              beforeSend: function() {
                $('.loader').fadeIn();
              },
              success: function(response) {
                console.log(response);
                if (response.trim() == "success") {
                  $('.loader').fadeOut();
                  swal("Success!", "Deletion successful!", "success");
                  table.row($('.datatable-expense-' + id)).remove().draw();
                } else {
                  $('.loader').fadeOut();
                  swal("Error!", "An error occurred, please try again!", "error");
                }
              }
            });
          }
        });
    }
  </script>
<?php

} else {
?>
  <script>
    window.open('../../', '_self')
  </script>
<?php
}


?>