<?php
session_start();
if($_SESSION['username'] != ''){

  $customerID = $_POST['customerID'];

  include_once 'connection.php';

  $sql = "DELETE FROM customer WHERE id = '$customerID'";
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
