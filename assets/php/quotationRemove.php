<?php
session_start();
if($_SESSION['username'] != ''){

  $quotationID = $_POST['quotationID'];

  include_once 'connection.php';

  $sql = "DELETE FROM quotation WHERE id = '$quotationID'";
  if ($con->query($sql)){
    echo "success";
  }else{
    echo mysqli_error($con);
  }

}else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
  </script>
  <?php
}
?>
