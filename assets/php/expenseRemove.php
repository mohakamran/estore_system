<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $expenseID = $_POST['expenseID'];

  include_once 'connection.php';

  $sql = "DELETE FROM expense WHERE id = '$expenseID'";
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
