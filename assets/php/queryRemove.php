<?php
session_start();
if($_SESSION['username'] != ''){

  $queryID = $_POST['queryID'];

  include_once 'connection.php';

  $sql = "DELETE FROM query WHERE id = '$queryID'";
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
