<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'viewProduct-v'.$_SESSION['userType'].'.php';
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

  $("#navProductTree").addClass("menu-open");
  $("#navProduct").addClass("active");
  $("#navViewProducts").addClass("active");

  var table;

  $(function () {
    table = $('#tableProduct').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function deleteProduct(id){

    swal({
      title: "Are you sure?",
      text: "This will delete the service from the database, However the invoices already genereated would not be affected!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: 'POST',
          url: "../../assets/php/productRemove.php",
          data: {
            productID: id
          },
          beforeSend: function() {
            $('.loader').fadeIn();
          },
          success: function(response) {
            console.log(response);
            if ( response.trim() == "success" ){
              $('.loader').fadeOut();
              swal("Success!", "Deletion successful!", "success");
              table.row( $('.datatable-product-'+id)).remove().draw();
            }else {
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

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
