<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  include_once 'connection.php';

  $response = "failed";

  $expenseAmount = $_POST['expenseAmount'];
  $expenseDate = $_POST['expenseDate'];
  $folderName = $_POST['folderName'];
  $fileNames = $_POST['fileNames'];
  $expenseDescription = $con -> real_escape_string($_POST['expenseDescription']);


  $sql = "INSERT INTO expense (expenseAmount, expenseDate, expenseDescription, folderName, fileNames)
  VALUES ('$expenseAmount', '$expenseDate', '$expenseDescription', '$folderName', '$fileNames')";

  if ($con->query($sql)){
    $response = "success";
  }else {
    $response = mysqli_error($con);
  }

  echo $response;

}
else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
</script>
<?php
}
?>
