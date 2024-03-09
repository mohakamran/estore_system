<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $folderName = $_POST['folderName'];

  include_once 'connection.php';

  $result= mysqli_query($con, "SELECT * FROM directory WHERE folderName = '$folderName'")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){
    echo "folderExists";
  }else{
    $sql = "INSERT INTO directory (folderName)
    VALUES ('$folderName')";

    if ($con->query($sql)){
      if (!file_exists('../uploads/'.$folderName)) {
        mkdir('../uploads/'.$folderName, 0777, true);
      }
      echo "success";
    }else{
      echo mysqli_error($con);
    }
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
