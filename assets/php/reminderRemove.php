<?php
session_start();
if($_SESSION['username'] != ''){

  $reminderID = $_POST['reminderID'];

  include_once 'connection.php';

  $sql = "DELETE FROM reminder WHERE id = '$reminderID'";
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
