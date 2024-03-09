<?php
session_start();
if(isset($_SESSION['userType'])){

  $employeeID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'viewReminder-v'.$_SESSION['userType'].'.php';
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

  $("#navReminderTree").addClass("menu-open");
  $("#navReminder").addClass("active");
  $("#navViewReminder").addClass("active");

  var table;

  $(function () {
    table = $('.tableReminder').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function viewReminder(id){
    window.open('reminderDetails.php?reminderID='+id,'_self');
  }

  function editReminder(id){
    window.open('editReminder.php?reminderID='+id,'_self');
  }

  function deleteReminder(id){

    var alertText = "";
    var deleteUrl = "";
    deleteUrl = "../../assets/php/reminderRemove.php";
    alertText = "The Reminder would be removed from the database!"

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
            reminderID: id
          },
          beforeSend: function() {
            $('.loader').fadeIn();
          },
          success: function(response) {
            console.log(response);
            if ( response.trim() == "success" ){
              $('.loader').fadeOut();
              swal("Success!", "Deletion successful!", "success");
              table.row( $('.datatable-reminder-'+id)).remove().draw();
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
