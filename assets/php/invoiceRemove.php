<?php
session_start();
if($_SESSION['username'] != ''){

  $invoiceID = $_POST['invoiceID'];

  include_once 'connection.php';

  $sql = "DELETE FROM invoice WHERE id = '$invoiceID'";
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
