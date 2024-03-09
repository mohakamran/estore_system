<?php
session_start();
if($_SESSION['username'] != ''){

  $folderID = $_POST['folderID'];
$folderName = $_POST['folderName'];

  include_once 'connection.php';

  $sql = "DELETE FROM directory WHERE id = '$folderID'";
  if ($con->query($sql)){
    array_map('unlink', glob("../uploads/".$folderName."/*.*"));
    rmdir('../uploads/'.$folderName);
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
