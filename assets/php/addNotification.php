<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $notificationTitle = $_POST['notificationTitle'];
  $notificationDescription = $_POST['notificationDescription'];
  $folderName = $_POST['folderName'];
  $fileNames = $_POST['fileNames'];
  $notificationDate = date('Y-m-d');

  include_once 'connection.php';

  $sql = "INSERT INTO notification (title, description, folderName, fileNames, notificationDate)
  VALUES ('$notificationTitle', '$notificationDescription', '$folderName', '$fileNames', '$notificationDate')";

  if ($con->query($sql)){
    echo "success";
  }else{
    echo mysqli_error($con);
  }

}
else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
</script>
<?php
}
?>
