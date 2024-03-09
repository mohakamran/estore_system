<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'directory.php';
  include '../elements/footer.php';

  ?>
  <script type="text/javascript">

  $(document).ready(function () {

    $("#navDirectory").addClass("active");

  });


  function addFolder(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/addFolder.php',
      data: {
        folderName: $('.folderName').val()
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Folder added", "success")
          .then((value) => {
            location.reload();
          });
        }else if(response.trim() == "folderExists"){
          $('.loader').fadeOut();
          swal("Error!", "Folder with same name already exists!", "error");
        }else {
          $('.loader').fadeOut();
          swal("Error!", "An error occurred, please try again!", "error");
        }
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
