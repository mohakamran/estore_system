<?php
session_start();
if($_SESSION['username'] != ''){

  $posterID = $_POST['posterID'];

  include_once 'connection.php';

  $sql = "DELETE FROM poster WHERE id = '$posterID'";
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
