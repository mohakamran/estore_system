<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $notificationID = $_POST['notificationID'];

  include_once 'connection.php';

  $sql = "DELETE from notification WHERE id = '$notificationID'";

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
